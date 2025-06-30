<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::all();

        return response()->json([
            'projects' => $projects,
        ], Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $projectData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $projectData['created_by'] = auth()->id();

        $project = Project::create($projectData);

        return response()->json([
            'project' => $project,
        ], Response::HTTP_CREATED);
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json([
            'project' => $project,
        ], Response::HTTP_OK);
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $projectData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:active,completed'],
            'description' => ['nullable', 'string'],
        ]);

        $project->update($projectData);

        return response()->json([
            'project' => $project,
        ], Response::HTTP_OK);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'message' => 'Project deleted.'
        ], Response::HTTP_OK);
    }
}
