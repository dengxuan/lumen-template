<?php

namespace App\Http\Controllers;

use App\Domain\Services\Abstractions\IRoleDomainService;
use OpenApi\Attributes as OA;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

/**
 * Role Api Controller.
 */
#[OA\Tag(name:"Role")]
class RoleController extends BaseController
{
    private IRoleDomainService $roleDomainService;

    public function __construct(IRoleDomainService $roleDomainService)
    {
        $this->roleDomainService = $roleDomainService;
    }

    /**
     * Get all roles.
     */
    #[OA\Get(path: '/api/roles/all', description: 'Get all roles', tags: ['Role'])]
    #[OA\Response(response: 200, description: "Ok")]
    #[OA\Response(response: 401, description: "Unauthorized")]
    public function all()
    {
        $roles = $this->roleDomainService->all();
        return response()->json($roles);
    }

    /**
     * Get the role by name.
     */
    #[OA\Get(path: '/api/roles/{name}', description: 'Get the role by name', tags: ['Role'])]
    #[OA\Response(response: 200, description: "Ok")]
    #[OA\Response(response: 401, description: "Unauthorized")]
    public function findByName($name)
    {
        $role = $this->roleDomainService->findByName($name);
        return response()->json($role);
    }

    /**
     * Create a role.
     */
    #[OA\Post(path: '/api/roles', description: 'Create a role', tags: ['Role'])]
    #[OA\Response(response: 200, description: "Ok")]
    #[OA\Response(response: 401, description: "Unauthorized")]
    #[OA\RequestBody(required: true, description: 'Create a role', content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(
            required: ['name'],
            description: 'Create a role',
            properties: [
                new OA\Property(property: 'name', type: 'string', description: 'role name'),
                new OA\Property(property: 'description', type: 'string', description: 'role description'),
            ]
        ),
    )
    )]
    public function create(Request $request)
    {
        $input = $request->object(['name']);
        $role = $this->roleDomainService->create($input->name);
        return response()->json($role);
    }

    /**
     * Update a role.
     */
    #[OA\Put(path: '/api/roles/{id}', description: 'Update a role', tags: ['Role'])]
    #[OA\Response(response: 200, description: "Ok")]
    #[OA\Response(response: 401, description: "Unauthorized")]
    #[OA\RequestBody(required: true, description: 'Update a role', content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(
            required: ['name'],
            description: 'Update a role',
            properties: [
                new OA\Property(property: 'name', type: 'string', description: 'role name'),
                new OA\Property(property: 'description', type: 'string', description: 'role description'),
            ]
        ),
    )
    )]
    public function update(Request $request, $id)
    {
        $input = $request->object(['name', 'description']);
        $role = $this->roleDomainService->update($id, [$input->name, $input->description]);
        return response()->json($role);
    }

    /**
     * Delete a role.
     */
    #[OA\Delete(path: '/api/roles/{id}', description: 'Delete a role', tags: ['Role'])]
    #[OA\Response(response: 200, description: "Ok")]
    #[OA\Response(response: 401, description: "Unauthorized")]
    public function delete($id)
    {
        $this->roleDomainService->delete($id);
        return response()->json(['message' => 'Role deleted']);
    }

    /**
     * Delete all roles.
     */
    #[OA\Delete(path: '/api/roles', description: 'Delete all roles', tags: ['Role'])]
    #[OA\Response(response: 200, description: "Ok")]
    #[OA\Response(response: 401, description: "Unauthorized")]
    public function deleteAll()
    {
        $this->roleDomainService->deleteAll();
        return response()->json();
    }
}