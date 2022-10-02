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

    public function bidAtAuction($offerId, $userId, $auctionId)
    {
        $this->offerRepository->attachUserToOffer($userId, $offerId);
        $this->sumOfferToTotalAuctionValue($offerId, $auctionId);
        $this->logRepository->store('User bid at auction', 'bid', $userId, $offerId);
    }

    public function sumOfferToTotalAuctionValue($offerId, $auctionId)
    {
        $offer = $this->offerRepository->getOfferById($offerId);
        $auction = $this->auctionRepository->getAuctionById($auctionId);

        $actualValue = $auction->total_value + $offer->value;

        $this->auctionRepository->update($auctionId, 'total_value', $actualValue);
    }
}
