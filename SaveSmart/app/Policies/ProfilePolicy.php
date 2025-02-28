<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    public function view(User $user, Profile $profile)
    {
        return $user->family_id === $profile->family_id;
    }

    public function create(User $user)
    {
        return $user->family_id !== null;
    }

    public function update(User $user, Profile $profile)
    {
        return $user->family_id === $profile->family_id;
    }

    public function delete(User $user, Profile $profile)
    {
        return $user->family_id === $profile->family_id && $user->isOwnerOfFamily();
    }
}
