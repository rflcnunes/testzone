<?php

namespace App\Http\Services;

use App\Http\Repositories\Interfaces\AuctionRepositoryInterface;
use App\Http\Repositories\Interfaces\LogRepositoryInterface;

class SetAuctionWinnerService
{
    private $auctionRepository;
    private $logRepository;

    public function __construct(AuctionRepositoryInterface $auctionRepository, LogRepositoryInterface $logRepository)
    {
        $this->auctionRepository = $auctionRepository;
        $this->logRepository = $logRepository;
    }

    public function setAuctionWinner($auction_id, $user_id, $offer_id, $date)
    {
        $this->auctionRepository->setAuctionWinner($auction_id, $user_id, $offer_id, $date);

        $payload = [
            'auction_id' => $auction_id,
            'user_id' => $user_id,
            'offer_id' => $offer_id,
            'date' => $date
        ];

        $message = 'User ' . $user_id . ' won auction ' . $auction_id . ' with offer ' . $offer_id;
        $action = 'set_auction_winner';
        $payload = json_encode($payload);

        $this->logRepository->store($message, $action, $user_id, $offer_id, $auction_id, $payload);
    }
}
