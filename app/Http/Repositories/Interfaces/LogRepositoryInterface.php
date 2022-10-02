<?php

namespace App\Http\Repositories\Interfaces;

interface LogRepositoryInterface
{
    public function getAllLog();
    public function store($message, $action, $user_id, $offer_id, $auction_id, $payload);
    public function getAllLogByAuctionId($auction_id);
    public function getAllLogByUserId($user_id);
    public function getAllLogByOfferId($offer_id);
}
