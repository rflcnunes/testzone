<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Repositories\Interfaces\OfferRepositoryInterface;
use App\Http\Repositories\Interfaces\AuctionRepositoryInterface;
use App\Http\Services\BidAtAuctionService;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\Auction;
use App\Models\Offer;
use App\Models\User;

class MakeBidTest extends TestCase
{
    use DatabaseMigrations;

    private $auctionRepository;
    private $userRepository;
    private $offerRepository;

    private $bidService;

    private $user;
    private $offer;
    private $auction;

    private $beforeValue;

    public function setUp(): void
    {
        parent::setUp();

        $this->auctionRepository = app(AuctionRepositoryInterface::class);
        $this->auction = new Auction();
        $this->auction->factory()->create();

        $this->userRepository = app(UserRepositoryInterface::class);
        $this->user = new User();
        $this->user->factory()->create();

        $this->offerRepository = app(OfferRepositoryInterface::class);
        $this->offer = new Offer();
        $this->offer->factory()->create();

        $this->beforeValue = $this->auctionRepository->getActualValueFromAuction(1);

        $this->bidService = app(BidAtAuctionService::class);
        $this->bidService->bidAtAuction(1, 1, 1);
    }

    public function test_make_bid()
    {
        $allAuctions = $this->auctionRepository->getAll();
        $allAuctions = $allAuctions->toArray();

        $allUsers = $this->userRepository->getAll();
        $allUsers = $allUsers->toArray();

        $offers = $this->offerRepository->getAttachedUsers(1);
        $offer = $this->offerRepository->getOfferById(1);

        $actualValue = $this->auctionRepository->getAuctionById(1)->total_value;

        $this->assertEquals($this->beforeValue + $offer->value, $actualValue);
        $this->assertDatabaseHas('offer_user', ['offer_id' => 1, 'user_id' => 1]);
        $this->assertDatabaseHas('auctions', ['id' => 1, 'total_value' => $actualValue]);
    }
}
