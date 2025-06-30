<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
        ], Response::HTTP_OK);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $user = User::create($credentials);

        return response()->json([
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'user' => $user,
        ], Response::HTTP_OK);
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        $credentials = $request->validated();

        $user->update($credentials);

        return response()->json([
            'user' => $user,
        ], Response::HTTP_CREATED);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted.'
        ], Response::HTTP_OK);
    }
}
