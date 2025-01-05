<?php

namespace App\Http\Controllers;

use App\Filament\Resources\UserResource\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function __construct(private UserService $userService)
    {
        $this->authorizeResource(User::class);
    }

    public function index(): ResourceCollection
    {
        $users = $this->userService->list(
            trashed: request()->boolean('trashed', false)
        );

        return UserResource::collection($users);
    }

    public function toggleStatus(User $user): JsonResponse
    {
        $this->authorize('changeStatus', $user);

        $user = $this->userService->toggleStatus($user);

        return response()->json([
            'message' => __('User status updated successfully'),
            'user' => new UserResource($user)
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $this->authorize('restore', User::class);

        $this->userService->restore($id);

        return response()->json([
            'message' => __('User restored successfully')
        ]);
    }
}
