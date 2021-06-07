<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Prod extends Model
{
    use HasFactory;
    //protected $perPage=10;
    //protected $touches=['category','store'];

    protected $fillable = [
        'name', 'category_id', 'description', 'price', 'sale_price', 'quantity',
        'image', 'status', 'slug', 'store_id',
    ];

    //protected $guarded = [];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(ProdImage::class,'prod_id','id');
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'prod_tag',
            'prod_id',
            'tag_id',
            'id',
            'id'
        );
    }
    //Accessors method: get{AttrName}Attribute
    //$prod->image_url
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            if(strpos($this->image,'http') === 0 ){
                return $this->image;
            }
            //return asset('uploads/' . $this->image);
            return Storage::disk('uploads')->url($this->image);
        }
        return asset('images/default-image.jpg');
    }

    //Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
    }

    public static function validateRoles()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image',
            'price' => 'numeric|min:0',
            'sale_price' => [
                'numeric', 'min:0', function ($attr, $value, $fail) {
                    $price = request()->input('price');
                    if ($value >= $price) {
                        $fail($attr . ' must be less than regular price');
                    }
                },

            ]
        ];
    }
}
