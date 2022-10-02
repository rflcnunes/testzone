<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;

class AuctionController extends Controller
{
    private $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function store()
    {
        // ...
    }
}
