<?php

namespace App\Http\Controllers;

use App\Events\Hello;
use App\Notifications\RealTimeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function broadcast()
    {
        // broadcast(new Hello());
        Auth::user()->notify(new RealTimeNotification("Here is a new Notification "));
    }

    public function listener()
    {
        return view('listener');
    }
}
