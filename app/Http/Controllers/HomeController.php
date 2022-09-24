<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{

    public function index()
    {
        // auth()->logout();
        // return redirect('login');
        // query

        return view('home');
    }
}
