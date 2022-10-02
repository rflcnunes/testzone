<?php

namespace App\Http\Repositories;

use App\Models\Offer;
use App\Http\Repositories\Interfaces\OfferRepositoryInterface;

class OfferRepository implements OfferRepositoryInterface
{
    private $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function create(array $data)
    {
        $this->offer->create($data);
    }

    public function getOfferById($id)
    {
        return $this->offer->find($id);
    }

    public function attachUserToOffer($user_id, $offer_id)
    {
        $this->offer->find($offer_id)->user()->attach($user_id);
    }

    public function getAttachedUsers($offer_id)
    {
        return $this->offer->find($offer_id)->user()->get();
    }
}
