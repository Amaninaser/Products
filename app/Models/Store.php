<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    public function prods()
    {
        return $this->hasMany(Prod::class, 'store_id', 'id');   
    }
}
