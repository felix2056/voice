<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function getStats()
    {
        $statistics = [];

        $statistics['totalPosts'] = Post::count();
        $statistics['totalViewers'] = User::role('Viewer')->count();
        $statistics['totalWriters'] = User::role('Writer')->count();
        $statistics['totalBroadcasters'] = User::role('Broadcaster')->count();

        return response()->json([
            'statistics' => $statistics
        ]);
    }
}
