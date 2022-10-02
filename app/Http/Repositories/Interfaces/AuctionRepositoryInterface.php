<?php

namespace App\Http\Repositories\Interfaces;

interface AuctionRepositoryInterface
{
    public function getModel();
    public function getAll();
    public function getAuctionById($id);
    public function getActualValueFromAuction($id);
    public function store(array $data);
    public function update($id, $column, $value);
}
