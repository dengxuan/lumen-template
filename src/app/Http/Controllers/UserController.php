<?php

namespace App\Http\Controllers;

use App\Domain\Services\Abstractions\IUserDomainService;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * User Api Controller.
 */
#[OA\Tag(name: "User")]
class UserController extends Controller
{

    private IUserDomainService $userDomainService;

    public function __construct(IUserDomainService $userDomainService)
    {
        $this->userDomainService = $userDomainService;
    }

    /**
     * 获取当前用户信息
     */
    #[OA\Get(path: '/api/user/prefile', description: 'Get user prefile', tags: ['User'])]
    #[OA\Response(response: '200', description: 'User prefile')]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    public function prefile()
    {
        return response()->json(auth()->user());
    }

    /**
     * 修改密码
     */
    #[OA\Post(path: '/api/user/change-password', description: 'Change Password', tags: ['User'])]
    #[OA\Response(response: '200', description: 'Change Password')]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\RequestBody(required: true, description: 'Change Password', content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(
            required: ['oldPassword', 'newPassword'],
            description: 'Change Password',
            properties: [
                new OA\Property(property: 'oldPassword', type: 'string', format: 'password', description: 'Old Password'),
                new OA\Property(property: 'newPassword', type: 'string', format: 'password', description: 'New Password'),
            ]
        ),
    ))]
    public function changePassword(Request $request)
    {
        $input = $request->object(['oldPassword', 'newPassword']);
        $user = auth()->user();
        if (!Hash::check($input->oldPassword, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user->password = Hash::make($input->newPassword);
        $user->save();
        return response()->json($user);
    }

    /**
     * 忘记密码
     */
    #[OA\Post(path: '/api/user/forget-password', description: 'Forget Password', tags: ['User'])]
    #[OA\Response(response: '200', description: 'Forget Password')]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\RequestBody(required: true, description: 'Forget Password', content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(
            required: ['email', 'password'],
            description: 'Forget Password',
            properties: [
                new OA\Property(property: 'email', type: 'string', format: 'email', description: 'Email Address'),
                new OA\Property(property: 'password', type: 'string', format: 'password', description: 'New Password'),
            ]
        ),
    ))]
    public function forgetPassword(Request $request)
    {
        $input = $request->object(['email', 'password']);
        $user = $this->userDomainService->forgetPassword($input->email);
        if ($user === null) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user->password = Hash::make($input->password);
        $user->save();
        return response()->json($user);
    }

    /**
     * 重置密码
     */
    #[OA\Post(path: '/api/user/reset-password', description: 'Reset Password', tags: ['User'])]
    #[OA\Response(response: '200', description: 'Reset Password')]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    #[OA\RequestBody(required: true, description: 'Reset Password', content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(
            required: ['email', 'password'],
            description: 'Reset Password',
            properties: [
                new OA\Property(property: 'email', type: 'string', format: 'email', description: 'Email Address'),
                new OA\Property(property: 'password', type: 'string', format: 'password', description: 'New Password'),
            ]
        ),
    ))]
    public function resetPassword(Request $request)
    {
        $input = $request->object(['email', 'password']);
        $user = $this->userDomainService->resetPassword($input->email, $input->password);
        if ($user === null) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user->password = Hash::make($input->password);
        $user->save();
        return response()->json($user);
    }

}