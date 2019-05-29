<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;

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
        $comm = Settings::where('type', "self funded agents")->get();
        return view('dashboard.content', ['comm' => $comm]);
    }
}
