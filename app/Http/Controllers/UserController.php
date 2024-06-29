<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function __invoke(): JsonResource
    {
        return UsersResource::collection(User::all());
    }
}
