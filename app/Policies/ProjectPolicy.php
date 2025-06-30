<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Project $project): bool
    {
        return $user->isAdmin() || $user->id === $project->created_by;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function update(User $user, Project $project): bool
    {
        return $user->isAdmin() || $user->id === $project->created_by;
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->isAdmin() || $user->id === $project->created_by;
    }

    public function addMember(User $user, Project $project): bool
    {
        return $user->isAdmin() || $user->id === $project->created_by;
    }
}
