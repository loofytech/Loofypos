<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelper;
use App\Models\Selling;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard() {
        $store = Store::where('store_slug', MyHelper::getActiveStore())->first();
        $selling = Selling::where('store_id', $store->id)->whereDate('created_at', Carbon::today())->sum('total');
        return view('dashboard.index', compact('selling'));
    }

    public function product() {
        return view('dashboard.product');
    }

    public function selling() {
        return view('dashboard.selling');
    }
}
