<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function changeStoreActive(Request $request) {
        try {
            $store = Store::where('store_slug', $request->store)->first();
            if (!$store) throw new \Exception('Error, store not found!');

            $request->session()->put('lfps_store', $store->store_slug);
            return response()->json(['message' => $store->store_slug]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
