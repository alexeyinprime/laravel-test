<?php

namespace App;

interface DescriptionInterface
{
    public function getDescription(): array;
    public function toArray();
}
