<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    //rules 
    public static function rules(){
        return [

        ];
    }
    
    public function prods()
    {
        return $this->hasMany(Prod::class, 'category_id', 'id');   
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');   
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => 'No Parent'
        ]);   
    }

}
