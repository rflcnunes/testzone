<?php

namespace App\Http\Repositories;

use App\Models\Auction;
use App\Http\Repositories\Interfaces\AuctionRepositoryInterface;
use Illuminate\Support\Facades\DB;


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

    public function closeAuction($id, $user_id, $offer_id, $date)
    {
        $this->auction->find($id)->update([
            'is_finished' => true,
            'end_date' => $date
        ]);

        $payload = [
            'auction_id' => $id,
            'total_value' => $this->getActualValueFromAuction($id),
            'end_date' => $date
        ];

        DB::table('logs')->insert([
            'message' => 'Auction closed',
            'action' => 'close',
            'user_id' => $user_id,
            'offer_id' => $offer_id,
            'auction_id' => $id,
            'payload' => json_encode($payload),
            'created_at' => $date,
            'updated_at' => now()
        ]);
    }

    public function setAuctionWinner($id, $user_id, $offer_id, $date)
    {
        $this->auction->find($id)->update([
            'winner_id' => $user_id
        ]);

        $payload = [
            'auction_id' => $id,
            'winner_id' => $user_id
        ];

        DB::table('logs')->insert([
            'message' => 'Auction winner set',
            'action' => 'set_winner',
            'user_id' => $user_id,
            'offer_id' => $offer_id,
            'auction_id' => $id,
            'payload' => json_encode($payload),
            'created_at' => $date,
            'updated_at' => now()
        ]);
    }
}
