<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'image', 'description', 'sataus', 'parent_id', 'slug'  ];

    
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

    public static function validateRoles()
    {
        return[
            'name' => [
                'required',
                'alpha',
                'max:255',
                'min:3',
            
              //Rule::unique('Categories', 'name')->ignore($id),
            ],
            'description' => [
                'required',
                'min:5',
                'filter:laravel,php',
            
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
            ],
            'image' => [
                'image',
                'max:1048576',
                'dimensions:min_width=200,min_heigth=200'
            ],
            'sataus' => [
                'required',
                'in:active,inactive'
            ],
        ];
    }
}
