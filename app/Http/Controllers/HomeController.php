<?php

namespace App\Http\Controllers;

use App\Models\Prod;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latest = Prod::latest()->take(10)->get();
        return view('front.home',[
            'latest' => $latest,
        ]);
    }
}
