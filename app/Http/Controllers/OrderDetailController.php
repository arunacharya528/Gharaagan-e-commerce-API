<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $order = OrderDetail::with([
            'orderItems',
            'orderItems.product',
            'orderItems.inventory.discount',
            'user',
            'address',
            'discount'
        ])->get();
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
        // $order = OrderDetail::create($request->all());
        // return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDetail $orderDetail)
    {
        $orderUser = OrderDetail::with('user')->find($orderDetail->id);
        $order = OrderDetail::with([
            'orderItems.product.ratings' => function ($query) use ($orderUser) {
                $query->where('user_id', $orderUser->user->id)->get();
            },
            'orderItems.product.images.file',
            'orderItems.inventory.discount',
            'address.delivery',
            'discount',
        ])->find($orderDetail->id);

        return response()->json($order);
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
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
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
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        DB::beginTransaction();
        try {
            OrderItem::where(['order_id' => $orderDetail->id])->delete();
            OrderDetail::destroy($orderDetail->id);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
        DB::commit();

        return response()->json("Successfully deleted order and its items");
    }


    /**
     * Cancels order and all of its components
     */
    public function cancelOrder(OrderDetail $orderDetail)
    {
        if (Auth::user()->role === 3 && Auth::user()->id !== $orderDetail->user_id) {
            return redirect()->route('unauthorized');
        }

        DB::beginTransaction();
        try {
            // getting all ordering items
            $orderItems = OrderItem::where(['order_id' => $orderDetail->id])->get();

            foreach ($orderItems as $item) {
                // adding deleting order quantity into the quantity of product
                $inventory = ProductInventory::find($item->inventory->id);
                $existingQuantity = $inventory->quantity;
                $inventory->quantity = $existingQuantity + $item->quantity;
                $inventory->save();
                $item->delete();
            }

            // deleting order detail
            OrderDetail::destroy($orderDetail->id);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
        DB::commit();

        return response()->json(['message' => "Order cancelled successfully"], 200);
    }

    public function streamInvoice(OrderDetail $orderDetail)
    {
        $order = OrderDetail::with([
            'orderItems.product.ratings',
            'orderItems.product.images.file',
            'orderItems.inventory.discount',
            'address.delivery',
            'discount',
        ])->find($orderDetail->id);

        if (Auth::user()->role === 3 && Auth::user()->id !== $order->user_id) {
            return redirect()->route('unauthorized');
        }

        $pdf = Pdf::loadView('invoice', ['orderDetail' => $order])->setPaper('a4', 'landscape');
        return $pdf->stream('invoice.pdf');
    }
}
