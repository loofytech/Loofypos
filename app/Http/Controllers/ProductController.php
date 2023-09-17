<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Illuminate\Support\Str;
use App\Helpers\MyHelper;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function getProductTest() {
        $product = Product::all();
        return response()->json(['data' => $product]);
    }

    public function index(Request $request) {
        $store = Store::where('store_slug', MyHelper::getActiveStore())->first();

        if ($request->ajax()) {
            $data = Product::where('store_id', $store->id)->latest()->get();
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

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'product_name' => 'required',
                'product_price' => 'required',
                'product_image' => 'required|file|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            ]);
            if($validator->fails()) throw new \Exception($validator->errors());

            $store = Store::where('store_slug', MyHelper::getActiveStore())->first();
            if (!$store) throw new \Exception('Store not found');

            $image = $request->file('product_image');
            $imageName = 'lfps_' . time() . rand(0, 100) . '_store' . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('/lfps_store_dump/');
            $pathToOutput = public_path('/lfps_store/');
            $image->move($imagePath, $imageName);

            // $optimizerChain = OptimizerChainFactory::create();
            ImageOptimizer::optimize($imagePath.$imageName, $pathToOutput.$imageName);

            unlink($imagePath.$imageName);

            $product = new Product();
            $product->product_name = $request->product_name;
            $product->product_slug = Str::slug($request->product_name . '_' . rand(0, 100), '-');
            $product->product_price = $request->product_price;
            $product->product_image = '/lfps_store/' . $imageName;
            $product->store_id = $store->id;
            $product->save();

            DB::commit();
            return response()->json(['message' => 'Submit Prodak OK']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
