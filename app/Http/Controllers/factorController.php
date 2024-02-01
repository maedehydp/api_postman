<?php

namespace App\Http\Controllers;

use App\Models\Factor;
use Illuminate\Http\Request;

class factorController extends Controller
{
    public function index() {
        $checks = Factor::all();
        return response()->json([
            'checks' => $checks,
        ]);
    }

    public function store(Request $request) {
        $factors = Factor::create([
            'user_id' => $request->user_id,
            'order_id' => $request->order_id,
            'finally_price' => $request->finally_price,
            'created_at'=>date('Y-m-d H:i:s'),
        ]);
        return response()->json(['factors' => $factors]);
    }
    public function destroy($id)
    {
        $factor_user_id = Factor::find($id)->user_id;
        $user_id = auth()->user()->id;
        if ($user_id == $factor_user_id) {
            Factor::find($id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'your factor is deleted',
            ]);
        } else {
            return response()->json([
                'message' => 'that is not your factor',
            ]);
        }
    }

    public function update_status($id)
    {
        $factor_user_id = Factor::find($id)->user_id;
        $user_id = auth()->user()->id;
        if ($user_id == $factor_user_id) {
            $status = Factor::findOrFail($id);
            $status->update(['status' => 'پرداخت شده']);
            return response([
                'status' => true,
                'message' => 'your status will be update'
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'you can not update this factor status Because that is not your factor'
            ]);
        }
    }
}
