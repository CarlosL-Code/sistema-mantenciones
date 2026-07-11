<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Repuesto;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepuestoPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Repuesto');
    }

    public function view(AuthUser $authUser, Repuesto $repuesto): bool
    {
        return $authUser->can('View:Repuesto');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Repuesto');
    }

    public function update(AuthUser $authUser, Repuesto $repuesto): bool
    {
        return $authUser->can('Update:Repuesto');
    }

    public function delete(AuthUser $authUser, Repuesto $repuesto): bool
    {
        return $authUser->can('Delete:Repuesto');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Repuesto');
    }

    public function restore(AuthUser $authUser, Repuesto $repuesto): bool
    {
        return $authUser->can('Restore:Repuesto');
    }

    public function forceDelete(AuthUser $authUser, Repuesto $repuesto): bool
    {
        return $authUser->can('ForceDelete:Repuesto');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Repuesto');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Repuesto');
    }

    public function replicate(AuthUser $authUser, Repuesto $repuesto): bool
    {
        return $authUser->can('Replicate:Repuesto');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Repuesto');
    }

}