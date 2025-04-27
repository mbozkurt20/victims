<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function statistics()
    {
        $data['totalVictims'] = Post::count();
        $data['pendingVictims'] = Post::where('status','pending')->count();
        $data['soldVictims'] = Post::where('status','sold')->count();
        $data['not_readyVictims'] = Post::where('status','not_ready')->count();
        $data['totalAmount'] = Post::sum('amount');

        return response()->json($data);
    }
}
