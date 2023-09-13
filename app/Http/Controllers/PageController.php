<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    public function dashboard() {
        return view('dashboard.index');
    }

    public function product() {
        return view('dashboard.product');
    }
}
