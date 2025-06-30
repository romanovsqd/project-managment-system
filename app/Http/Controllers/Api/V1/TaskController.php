<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Project;

class TaskController extends Controller
{
    public function index(Project $project): JsonResponse
    {
        $tasks = $project->tasks()->get();

        return response()->json([
            'tasks' => $tasks,
        ], Response::HTTP_OK);
    }

    public function store(Request $request, Project $project): JsonResponse
    {
        $taskData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $taskData['project_id'] = $project->id;

        $task = Task::create($taskData);

        return response()->json([
            'task' => $task,
        ], Response::HTTP_CREATED);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json([
            'task' => $task,
        ], Response::HTTP_OK);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $taskData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:to_do,in_progress,done'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $task->update($taskData);

        return response()->json([
            'task' => $task,
        ], Response::HTTP_OK);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted.'
        ], Response::HTTP_OK);
    }
}
