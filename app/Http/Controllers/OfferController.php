<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Http\Services\BidAtAuctionService;

class OfferController extends Controller
{
    private $offer;
    private $bidAtAuction;

    public function __construct(Offer $offer, BidAtAuctionService $bidAtAuction)
    {
        $this->offer = $offer;
    }

    public function store(Request $request)
    {
        $request = $request->validate([
            'value' => 'required|double'
        ], [
            'value.required' => 'The value is required',
            'value.double' => 'The value must be a double'
        ]);

        $this->offer->create([
            'value' => $request->value
        ]);

        $this->bidAtAuction->bidAtAuction($this->offer->id, $request->user()->id);

        return response()->json([
            'message' => 'Offer created successfully'
        ], 201);
    }

    public function all()
    {
        return $this->offer->all();
    }
}
