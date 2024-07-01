<?php

namespace App;
use App\DescriptionInterface;


class UserWithDescription implements DescriptionInterface {

    public DescriptionInterface $user;

    public function __construct(DescriptionInterface $user)
    {
        $this->user = $user;
    }

    public function getDescription(): array
    {
        return (array)array_rand(array_flip(['php','js','java','go']),rand(1,4));
    }

    public function toArray()
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'description' => $this->getDescription(),
        ];
    }
}
