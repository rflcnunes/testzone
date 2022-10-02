<?php

namespace App\Http\Repositories\Interfaces;

interface LogRepositoryInterface
{
    public function store($message, $action, $user_id, $payload);
}
