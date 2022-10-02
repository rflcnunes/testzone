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
        return $this->offer->create($data);
    }

    public function getAll()
    {
        return $this->offer->all();
    }

    public function getOfferById($id)
    {
        return $this->offer->find($id);
    }

    public function getOfferWithGreaterValue()
    {
        $offers = $this->getAll();

        return $offers->sortByDesc('value')->first();
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
