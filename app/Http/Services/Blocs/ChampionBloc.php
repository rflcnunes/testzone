<?php

namespace App\Http\Services\Blocs;

class ChampionBloc
{
    private $user;
    private $offerValue;
    private $offer;

    public function setChampion($user, $offerValue, $offer)
    {
        $this->offer = $offer;
        $this->offerValue = $offerValue;
        $this->user = $user;

        return $this->createBloc();
    }

    public function createBloc()
    {
        return [
            'champion' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'offer_value' => $this->offerValue,
                'offer_id' => $this->offer->toArray(),
            ]
        ];
    }
}
