<?php

namespace App\Http\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAll();
    public function attachUserToOffer($user_id, $offer_id);
}
