<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Services\BidAtAuctionService;
use App\Http\Repositories\Interfaces\OfferRepositoryInterface;

class UserController extends Controller
{
    private $user;

    private $bidAuction;
    private $offerRepository;

    public function __construct(User $user, OfferRepositoryInterface $offerRepository, BidAtAuctionService $bidAuction)
    {
        $this->user = $user;
        $this->bidAuction = $bidAuction;
        $this->offerRepository = $offerRepository;
    }

    public function getName(): string
    {
        return $this->user->getName();
    }

    public function store(Request $request)
    {
        $this->user->create($request->all());
    }

    public function all()
    {
        return $this->user->all();
    }

    public function bidAtAuction(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'auction_id' => 'required|integer',
            'offer_value' => 'required|integer',
        ]);

        return $this->bidAuction->createOffer($request->offer_value, $request->user_id, $request->auction_id);
    }
}
