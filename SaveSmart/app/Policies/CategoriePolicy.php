<?php

namespace App\Policies;

use App\Models\Categorie;
use App\Models\User;

class CategoriePolicy
{
    public function update(User $user, Categorie $categorie)
    {
        return $user->id === $categorie->user_id;
    }

    public function delete(User $user, Categorie $categorie)
    {
        return $user->id === $categorie->user_id;
    }
}
