<?php

namespace App\Http\Repositories;

use App\Models\Log;
use App\Http\Repositories\Interfaces\LogRepositoryInterface;

class LogRepository implements LogRepositoryInterface
{
    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function store($message, $action, $user_id, $payload)
    {
        $this->log->create([
            'message' => $message,
            'action' => $action,
            'user_id' => $user_id,
            'payload' => $payload
        ]);
    }
}
