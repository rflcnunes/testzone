<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Http\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Repositories\Interfaces\OfferRepositoryInterface;
use App\Http\Repositories\Interfaces\AuctionRepositoryInterface;
use App\Http\Repositories\Interfaces\LogRepositoryInterface;
use App\Http\Services\BidAtAuctionService;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\Auction;
use App\Models\Offer;
use App\Models\User;

class SetAChampionByAuctionTest extends TestCase
{
    use DatabaseMigrations;

    private $userRepository;
    private $logRepository;

    private $users;
    private $user;
    private $log;

    private $offerWithGreaterValue;

    private $bidService;

    private $auctionLog;

    public function setUp(): void
    {
        parent::setUp();

        $randOfferId = rand(1, 17);
        $randUserId = rand(1, 10);
        $randAuctionId = rand(1, 5);

        $this->logRepository = app(LogRepositoryInterface::class);

        $this->auctionRepository = app(AuctionRepositoryInterface::class);
        $this->auction = new Auction();
        $this->auction->factory()->count(5)->create();

        $this->userRepository = app(UserRepositoryInterface::class);
        $this->users = new User();
        $this->users->factory()->count(10)->create();

        $this->user = $this->userRepository->getUserById($randUserId);

        $this->offerRepository = app(OfferRepositoryInterface::class);
        $this->offer = new Offer();
        $this->offer->factory()->count(17)->create();

        $offers = $this->offerRepository->getAll();

        $this->bidService = app(BidAtAuctionService::class);

        foreach ($offers as $offer) {
            $this->bidService->bidAtAuction($offer->id, rand(1, 10), rand(1, 5));
        }

        $this->offerWithGreaterValue = $this->offerRepository->getOfferWithGreaterValue();

        $this->auctionRepository->closeAuction(1, $this->user->id, $this->offerWithGreaterValue->id, now());

        $this->log = $this->logRepository->getAllLog();

        $this->auctionLog = $this->logRepository->getAllLogByAuctionId(1);

        $this->auctionRepository->setAuctionWinner(1, $this->user->id, $this->offerWithGreaterValue->id, now());
    }

    public function test_set_a_champion_by_auction()
    {
        $offerValue = $this->offerWithGreaterValue->value;
        $offerId = $this->offerWithGreaterValue->id;

        $this->assertDatabaseHas('logs', [
            'auction_id' => 1,
            'user_id' => $this->user->id,
        ]);

        $this->assertDatabaseHas('logs', [
            'payload->offer_id' => $offerId,
            'payload->offer_value' => $offerValue,
        ]);

        $this->assertDatabaseHas('auctions', [
            'id' => 1,
            'is_finished' => true,
        ]);

        $this->assertDatabaseHas('logs', [
            'auction_id' => 1,
            'payload->winner_id' => $this->user->id,
        ]);
    }

    public function test_create_champion_bloc()
    {
        $this->assertDatabaseHas('logs', [
            'auction_id' => 1,
            'payload->winner_id' => $this->user->id,
        ]);
    }
}
