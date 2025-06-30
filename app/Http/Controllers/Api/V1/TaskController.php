<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function index(Project $project): JsonResponse
    {
        $tasks = $project->tasks()->get();

        return response()->json([
            'tasks' => $tasks,
        ], Response::HTTP_OK);
    }

    public function store(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $taskData = $request->validated();

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

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $taskData = $request->validated();

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
