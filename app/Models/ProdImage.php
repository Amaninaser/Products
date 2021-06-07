<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProdImage extends Model
{
    use HasFactory;
    protected $fillable =[
        'image_path','prod_id'
    ];
    public function prod()
    {
        return $this->belongsTo(Prod::class,'prod_id','id');
    }
    public function getImageUrlAttribute()
    {
            return Storage::disk('uploads')->url($this->image_path);
        
    }
}
