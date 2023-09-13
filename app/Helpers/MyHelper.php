<?php

namespace App\Helpers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;

class MyHelper {
  public static function getStore() {
    $store = Store::where('user_id', Auth::user()->id)->get();

    return $store;
  }

  public static function getActiveStore() {
    $store = Store::where('store_slug', session()->get('lfps_store'))->first();

    if ($store) return $store->store_slug;
    return null;
  }
}