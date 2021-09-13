<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Store extends User implements MustVerifyEmail
{
    use HasFactory;
    public function prods()
    {
        return $this->hasMany(Prod::class, 'store_id', 'id');   
    }
}
