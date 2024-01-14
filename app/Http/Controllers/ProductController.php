<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function store(Request $request)
    {
        try {
            Product::create([
                'title' => $request->title,
                'price' => $request->price,
                'inventory' => $request->inventory,
                'description' => $request->description,
                'user_id' => $request->user_id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'your product saved in database',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "{$e->getMessage()}",
            ]);
        }

    }

    public function index()
    {
        $product = Product::all();
        return response()->json([
            'product' => $product
        ]);
    }

    public function destroy($id)
    {
        try {
            $products = Product::find($id);
            $products->delete();
            return \response()->json([
                'status' => true,
                'message' => 'product is deleted'
            ]);
        } catch (\Exception $e) {
            return \response()->json([
                'status' => false,
                'message' => "{$e->getMessage()}",
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $products = Product::find($id)->updateOrFail([
                'title' => $request->product_name,
                'price' => $request->price,
                'inventory' => $request->amount_available,
                'description' => $request->explanation,
            ]);
            return response()->json([
                'products' => $products
            ]);
        } catch (\Exception $e) {
            return \response()->json([
                'status' => false,
                'message' => "{$e->getMessage()}"
            ]);
        }
    }
}
