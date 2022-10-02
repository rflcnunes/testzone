<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
}
