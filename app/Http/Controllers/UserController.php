<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

use App\UserWithDescription;

class UserController extends Controller
{
    public function __invoke(): JsonResource
    {
        $UsersWithDescription = new Collection();

        foreach (User::all() as $user) {
            $UsersWithDescription->add(
                new UserWithDescription($user)
                );
        }
        // return decorated User model
        return UsersResource::collection($UsersWithDescription);

        //return vanilla User model
        //return UsersResource::collection(User::all());
    }
}



