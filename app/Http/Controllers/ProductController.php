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
        $product = Product::create($request->all());
        return response()->json([
            ''=>$product,
            'created successfully'
        ]);

    }
}
