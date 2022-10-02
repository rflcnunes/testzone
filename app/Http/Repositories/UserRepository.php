<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function attachUserToOffer($user_id, $offer_id)
    {
        $this->user->find($user_id)->offer()->attach($offer_id);
    }
}
