<?php

namespace App\Http\Services;

use App\Http\Repositories\Interfaces\LogRepositoryInterface;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Repositories\Interfaces\OfferRepositoryInterface;
use App\Http\Repositories\Interfaces\AuctionRepositoryInterface;

class BidAtAuctionService
{
    private $logRepository;
    private $userRepository;
    private $offerRepository;
    private $auctionRepository;

    public function __construct(LogRepositoryInterface $logRepository, UserRepositoryInterface $userRepository, OfferRepositoryInterface $offerRepository, AuctionRepositoryInterface $auctionRepository)
    {
        $this->logRepository = $logRepository;
        $this->userRepository = $userRepository;
        $this->offerRepository = $offerRepository;
        $this->auctionRepository = $auctionRepository;
    }

    public function createOffer($value, $user_id, $auction_id)
    {
        $offer = $this->offerRepository->create([
            'value' => $value,
        ]);

        $this->bidAtAuction($offer->id, $user_id, $auction_id);
    }

    public function bidAtAuction($offerId, $userId, $auctionId)
    {
        $this->offerRepository->attachUserToOffer($userId, $offerId);
        $this->sumOfferToTotalAuctionValue($offerId, $auctionId);

        $payload = [
            'offer_id' => $offerId,
            'user_id' => $userId,
            'auction_id' => $auctionId,
            'offer_value' => $this->offerRepository->getOfferById($offerId)->value
        ];

        $message = 'User ' . $userId . ' made a bid on auction ' . $auctionId . ' with offer ' . $offerId;
        $action = 'bid';
        $payload = json_encode($payload);

        $this->logRepository->store($message, $action, $userId, $offerId, $auctionId, $payload);
    }

    public function sumOfferToTotalAuctionValue($offerId, $auctionId)
    {
        $offer = $this->offerRepository->getOfferById($offerId);
        $auction = $this->auctionRepository->getAuctionById($auctionId);

        $actualValue = $auction->total_value + $offer->value;

        $this->auctionRepository->update($auctionId, 'total_value', $actualValue);
    }
}
