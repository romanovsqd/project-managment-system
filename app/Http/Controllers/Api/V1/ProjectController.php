<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Project;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::all();

        return response()->json([
            'projects' => $projects,
        ], Response::HTTP_OK);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $projectData = $request->validated();

        $user = auth()->user();

        $projectData['created_by'] = $user->id;
        
        $project = Project::create($projectData);
        $project->members()->attach($user);

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

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $projectData = $request->validated();

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
