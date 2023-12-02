<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository extends Repository
{
    public function model(): string
    {
        return User::class;
    }
}
