<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;

class WelcomeController extends Controller
{
    public function index()
    {
        $stories = Story::all();

        return view('HackerNews.home', compact('stories'));
    }
}
