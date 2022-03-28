<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = OrderDetail::get();
        return response()->json($order);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = OrderDetail::create($request->all());
        return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDetail $orderDetail)
    {
        $session = OrderDetail::find($orderDetail->id);
        return response()->json($session);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderDetail $orderDetail)
    {
        $order = OrderDetail::find($orderDetail->id);
        $order->update($request->all());
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderDetail $orderDetail)
    {
        return OrderDetail::destroy($orderDetail->id);
    }

    /**
     * Get order detail by user id
     */
    public function getByUser($user_id)
    {
        if (User::find($user_id)->id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }

        $orderDetail = User::with('orderDetails.orderItems.product')->find($user_id);

        return response()->json($orderDetail);
    }

    /**
     * Cancels order and all of its components
     */
    public function cancelOrder($order_id)
    {
        if (OrderDetail::find($order_id)->user->id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }
        DB::beginTransaction();
        try {
            // delete ordering item
            OrderItem::where(['order_id' => $order_id])->delete();
            // deleting order detail
            OrderDetail::destroy($order_id);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            DB::rollBack();
            return response()->json(['message' => "There was problem creating order"], 409);
        }
        DB::commit();

        return response()->json(['message' => "Order cancelled successfully"], 200);
    }
}
