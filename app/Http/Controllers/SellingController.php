<?php

namespace App\Http\Controllers;

use App\Models\Selling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Store;
use App\Helpers\MyHelper;
use Yajra\DataTables\Facades\DataTables;

class SellingController extends Controller
{
    public function getSellingData(Request $request) {
        $store = Store::where('store_slug', MyHelper::getActiveStore())->first();

        if ($request->ajax()) {
            $data = Selling::where('store_id', $store->id)->with('ProductSale', 'store')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function checkout(Request $request) {
        try {
            DB::beginTransaction();

            $selling = new Selling();
            $selling->code = "LP-". time() . rand(10, 100);
            $selling->store_id = $request->store_id;
            $selling->total = 0;
            $selling->save();

            $total = 0;

            foreach ($request->products as $key => $prd) {
                DB::table('product_sale')->insert([
                    'selling_id' => $selling->id,
                    'product_id' => $prd['id'],
                    'quantity' => $prd['quantity'],
                    'sub_total' => $prd['price'] * $prd['quantity'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $total = $total + ($prd['price'] * $prd['quantity']);
            }

            $selling->total = $total;
            $selling->save();

            DB::commit();
            return response()->json(['message' => "Checkout OK!"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
