<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Mantencion;
use Illuminate\Auth\Access\HandlesAuthorization;

class MantencionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Mantencion');
    }

    public function view(AuthUser $authUser, Mantencion $mantencion): bool
    {
        return $authUser->can('View:Mantencion');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Mantencion');
    }

    public function update(AuthUser $authUser, Mantencion $mantencion): bool
    {
        return $authUser->can('Update:Mantencion');
    }

    public function delete(AuthUser $authUser, Mantencion $mantencion): bool
    {
        return $authUser->can('Delete:Mantencion');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Mantencion');
    }

    public function restore(AuthUser $authUser, Mantencion $mantencion): bool
    {
        return $authUser->can('Restore:Mantencion');
    }

    public function forceDelete(AuthUser $authUser, Mantencion $mantencion): bool
    {
        return $authUser->can('ForceDelete:Mantencion');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Mantencion');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Mantencion');
    }

    public function replicate(AuthUser $authUser, Mantencion $mantencion): bool
    {
        return $authUser->can('Replicate:Mantencion');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Mantencion');
    }

}