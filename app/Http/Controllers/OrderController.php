<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\PaymentMode;
use App\Models\PaymentStatus;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id','desc')->get()->map(function($order){
            $order->name = User::find($order->user_id)->first_name.''.User::find($order->user_id)->last_name;
            $order->mobile = User::find($order->user_id)->mobile;
            $order->city = User::find($order->user_id)->city;
            $order->email = User::find($order->user_id)->email;
            $order->payment_status = isset(PaymentStatus::find($order->payment_status)->name) ? PaymentStatus::find($order->payment_status)->name :'';
            $order->payment_mode = isset(PaymentMode::find($order->payment_mode)->name) ? PaymentMode::find($order->payment_mode)->name :'';
            $order->order_status = isset(OrderStatus::find($order->order_status)->name) ? OrderStatus::find($order->order_status)->name :'';
            $order->items = OrderItem::where('order_id',$order->id)->count();
            return $order;
        });
        return view('orders.index',compact('orders'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        
        return view('orders.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->back()->with('success','Order delete successfully');
    }
}
