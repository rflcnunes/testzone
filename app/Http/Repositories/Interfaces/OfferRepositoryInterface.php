<?php

namespace App\Http\Repositories\Interfaces;

interface OfferRepositoryInterface
{
    public function create(array $data);
    public function getAll();
    public function getOfferById($id);
    public function attachUserToOffer($user_id, $offer_id);
    public function getAttachedUsers($offer_id);
    public function getOfferWithGreaterValue();
}
