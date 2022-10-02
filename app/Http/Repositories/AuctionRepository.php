<?php

namespace App\Http\Repositories;

use App\Models\Auction;
use App\Http\Repositories\Interfaces\AuctionRepositoryInterface;

class AuctionRepository implements AuctionRepositoryInterface
{
    private $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function getModel()
    {
        return $this->auction;
    }

    public function getAll()
    {
        return $this->auction->all();
    }

    public function getAuctionById($id)
    {
        return $this->auction->find($id);
    }

    public function getActualValueFromAuction($id)
    {
        return $this->auction->find($id)->total_value;
    }

    public function store(array $data)
    {
        $this->auction->create($data);
    }

    public function update($id, $column, $value)
    {
        $this->auction->find($id)->update([
            $column => $value
        ]);
    }
}
