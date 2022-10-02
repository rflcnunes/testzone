<?php

namespace App\Http\Repositories;

use App\Models\Log;
use App\Http\Repositories\Interfaces\LogRepositoryInterface;

class LogRepository implements LogRepositoryInterface
{
    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function getAllLog()
    {
        return $this->log->all();
    }

    public function store($message, $action, $user_id, $offer_id, $auction_id, $payload)
    {
        $this->log->create([
            'message' => $message,
            'action' => $action,
            'user_id' => $user_id,
            'offer_id' => $offer_id,
            'auction_id' => $auction_id,
            'payload' => $payload
        ]);
    }

    public function getAllLogByOfferId($offer_id)
    {
        return $this->log->where('offer_id', $offer_id)->get();
    }

    public function getAllLogByAuctionId($auction_id)
    {
        return $this->log->where('auction_id', $auction_id)->get();
    }

    public function getAllLogByUserId($user_id)
    {
        return $this->log->where('user_id', $user_id)->get();
    }
}
