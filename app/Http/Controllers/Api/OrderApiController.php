<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        Order::create([
            'user_id' => auth()->id(),
            'post_id' => $request->id,
        ]);
        return response()->json([
            'message' => 'Order created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if($order->user()->id === auth()->id()){
            return response()->json([$order]);
        }
        return response()->json([
            'message' => 'Order not found'
        ], 403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
