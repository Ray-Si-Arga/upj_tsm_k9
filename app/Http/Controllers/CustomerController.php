<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Index
    public function index()
    {
        return view('pelanggan.dashboard');
    }
}
