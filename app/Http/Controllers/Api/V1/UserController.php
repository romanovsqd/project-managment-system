<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();

        return response()->json([
            'users' => $users,
        ], Response::HTTP_OK);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $credentials = $request->validated();

        $user = User::create($credentials);

        return response()->json([
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize('view', User::class);

        return response()->json([
            'user' => $user,
        ], Response::HTTP_OK);
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', User::class);

        $credentials = $request->validated();

        $user->update($credentials);

        return response()->json([
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', User::class);

        $user->delete();

        return response()->json([
            'message' => 'User deleted.'
        ], Response::HTTP_OK);
    }
}
