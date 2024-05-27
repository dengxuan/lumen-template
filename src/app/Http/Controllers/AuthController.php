<?php

namespace App\Http\Controllers;

use App\Domain\Services\Abstractions\IUserDomainService;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * Auth Api Controller.
 */
#[OA\Tag(name: "Auth")]
class AuthController extends Controller
{
    private IUserDomainService $userDomainService;

    public function __construct(IUserDomainService $userDomainService)
    {
        $this->userDomainService = $userDomainService;
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * 注册
     */
    #[OA\Post(path: '/auth/sign-up', description: 'Sign Up', tags: ['Auth'])]
    #[OA\Response(response: 200, description: "Ok")]
    #[OA\Response(response: 400, description: "Bad Request")]
    #[OA\RequestBody(required: true, description: 'Sign Up', content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(
            required: ['name', 'email', 'password'],
            description: 'Sign Up',
            properties: [
                new OA\Property(property: 'name', type: 'string', description: 'user name'),
                new OA\Property(property: 'email', type: 'string', format: 'email', description: 'email address'),
                new OA\Property(property: 'password', type: 'string', format: 'password', description: 'password'),
            ]
        ),
    )
    )]
    public function signUp(Request $request)
    {
        $input = $request->object(['name', 'email', 'password']);
        $any = $this->userDomainService->any($input->name, $input->email);
        if ($any) {
            return response()->json(['error' => lang('auth.user_exists')], 400);
        }

        // 获取最大的用户Id，如果没有注册的用户，则默认1000000。Id每次随机增长1-100
        $id = $this->userDomainService->maxId() + rand(1, 100) ?? 1000000;
        $user = $this->userDomainService->create([
            'id' => $id,
            'name' => $input->name,
            'email' => $input->email,
            'password' => Hash::make($input->password),
        ]);

        return response()->json($user);
    }

    /**
     * 登录
     */
    #[OA\Get(path: '/auth/sign-in', description: 'Sign In', tags: ['Auth'])]
    #[OA\Response(response: '200', description: 'Sign In')]
    #[OA\Response(response: '401', description: 'Username or password is incorrect')]
    #[OA\RequestBody(required: true, description: 'Sign Up', content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(
            required: ['name', 'password', 'remember'],
            description: 'Sign Up',
            properties: [
                new OA\Property(property: 'username', type: 'string', description: 'User Name'),
                new OA\Property(property: 'password', type: 'string', format: 'password', description: 'Password'),
                new OA\Property(property: 'remember', type: 'boolean', description: 'Remember Me'),
            ]
        ),
    )
    )]
    public function signIn(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $remember = $request->remember;
        $token = auth()->attempt($credentials, $remember);
        if ($token === false) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->successWithToken($token);
    }

    /**
     * 退出登录
     */
    #[OA\Get(path: '/auth/sign-out', tags: ['Auth'])]
    #[OA\Response(response: '200', description: 'Sign Out')]
    public function signOut(Request $request)
    {
        try {
            // 获取当前请求中的访问令牌并刷新它
            auth()->logout();
            return response()->json();
        } catch (\Exception $e) {
            Log::error('sign-out:' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * 刷新令牌
     */
    #[OA\Get(path: '/auth/refresh', tags: ['Auth'])]
    #[OA\Response(response: '200', description: 'Refresh token')]
    public function refresh(Request $request)
    {
        try {
            $input = $request->object(['forceForever', 'resetClaims']);
            // 获取当前请求中的访问令牌并刷新它
            $token = auth()->refresh($input->forceForever, $input->resetClaims);
            return $this->successWithToken($token);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

}
