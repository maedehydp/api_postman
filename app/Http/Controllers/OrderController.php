<?php

namespace App\Http\Controllers;

use App\Events\order_create;
use App\Models\Order;
use App\Models\product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function filter(Request $request)
    {
        $filter = Order::query();
        $total_price = $request->input('total_price');
        $user_id = $request->input('user_id');
        $title = $request->input('title');
        if ($total_price) {
            $filter->where('total_price', $total_price);
        }
        if ($user_id) {
            $filter->where('user_id', $user_id);
        }
        if ($title) {
            $filter->where('title', $title);
        }
        $filterOrder = $filter->get();
        return \response()->json([
            'filterOrder' => $filterOrder,
        ]);
    }

    public function index()
    {
        $orders = Order::all();
        return response()->json([
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        dd($request);
        $total_price = 0;
        foreach ($request->products as $product) {
            $price = Product::find($product['product_id'])->price;
            $total_price += $price * $product['count'];
        }

        $orders = Order::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'total_price' => $total_price
        ]);
        foreach ($request->products as $product) {
            $orders->products()->attach($product['product_id'], ['count' => $product['count']]);
        }
        event(new order_create($orders));

        return \response()->json([
            'status' => '200',
            'message' => 'successfully'
        ]);
    }

//    public function store(Request $request)
//    {
//        // dd($request->products);
//        $total_price = 0;
//
//        // Check if $request->products is not null and is an array
//        if (!is_null($request->products) && is_array($request->products)) {
//            foreach ($request->products as $product) {
//                $price = Product::find($product['product_id'])->price;
//                $total_price += $price * $product['count'];
//            }
//        } else {
//            // Handle the case when $request->products is null or not an array (maybe log an error)
//            return \response()->json([
//                'error' => 'Products data is invalid or missing',
//            ]);
//        }
//
//        $order = Order::create([
//            'user_id' => $request->user_id,
//            'title' => $request->title,
//            'total_price' => $total_price
//        ]);
//
//        // Iterate over products only if $request->products is not null
//        if (!is_null($request->products)) {
//            foreach ($request->products as $product) {
//                $order->products()->attach($product['product_id'], ['count' => $product['count']]);
//            }
//        }
//
//        return \response()->json([
//            'status' => 'successfully',
//            'order_id' => $order->id
//        ]);
//    }


    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $total_price = 0;

        foreach ($request->products as $product) {
            $price = Product::find($product['product_id'])->price;
            $total_price += $price * $product['count'];
            $order->products()->syncWithoutDetaching([$product['product_id'] => ['count' => $product['count']]]);
        }

        $order->update([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'total_price' => $total_price
        ]);

        return response()->json([
            'status' => true,
            'order' => $order,
            'products' => $order->products,
        ]);
    }

    public function destroy($id)
    {
        try {
            Order::find($id)->delete();
            return \response()->json([
                'status' => true,
                'message' => 'your order has been deleted'
            ]);
        } catch (\Exception $e) {
            return \response()->json([
                'status' => false,
                'message' => "{$e->getMessage()}"
            ]);
        }
    }
}
