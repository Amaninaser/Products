<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function prods($id)
    {
        $tag = Tag::findOrFail($id);
        
        return $tag->prods;
    }
}
