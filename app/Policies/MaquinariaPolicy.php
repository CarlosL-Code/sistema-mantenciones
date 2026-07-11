<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Maquinaria;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaquinariaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Maquinaria');
    }

    public function view(AuthUser $authUser, Maquinaria $maquinaria): bool
    {
        return $authUser->can('View:Maquinaria');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Maquinaria');
    }

    public function update(AuthUser $authUser, Maquinaria $maquinaria): bool
    {
        return $authUser->can('Update:Maquinaria');
    }

    public function delete(AuthUser $authUser, Maquinaria $maquinaria): bool
    {
        return $authUser->can('Delete:Maquinaria');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Maquinaria');
    }

    public function restore(AuthUser $authUser, Maquinaria $maquinaria): bool
    {
        return $authUser->can('Restore:Maquinaria');
    }

    public function forceDelete(AuthUser $authUser, Maquinaria $maquinaria): bool
    {
        return $authUser->can('ForceDelete:Maquinaria');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Maquinaria');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Maquinaria');
    }

    public function replicate(AuthUser $authUser, Maquinaria $maquinaria): bool
    {
        return $authUser->can('Replicate:Maquinaria');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Maquinaria');
    }

}