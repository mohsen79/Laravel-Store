<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use UxWeb\SweetAlert\SweetAlert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        alert()->success('welcome to your panel dear' . ' ' . auth()->user()->name);
        return view('admin/users/panel');
    }
}
