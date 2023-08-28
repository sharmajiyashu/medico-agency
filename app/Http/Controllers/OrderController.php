<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\PaymentMode;
use App\Models\PaymentStatus;
use App\Models\Product;
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
        

        $payment_status = PaymentStatus::where('status',PaymentStatus::$active)->where('id','!=',$order->payment_status)->get();
        $payment_mode = PaymentMode::where('status',PaymentMode::$active)->where('id','!=',$order->payment_mode)->get();
        $order_status = OrderStatus::where('status',OrderStatus::$active)->where('id','!=',$order->order_status)->get();

        $order->payment_status = isset(PaymentStatus::find($order->payment_status)->name) ? PaymentStatus::find($order->payment_status)->name :'';
        $order->payment_mode = isset(PaymentMode::find($order->payment_mode)->name) ? PaymentMode::find($order->payment_mode)->name :'';
        $order->order_status = isset(OrderStatus::find($order->order_status)->name) ? OrderStatus::find($order->order_status)->name :'';        

        $items = OrderItem::where('order_id',$order->id)->get()->map(function($items){
            $items->product_name = isset(Product::find($items->product_id)->name) ? Product::find($items->product_id)->name :'';
            return $items;
        });
        $user = User::find($order->user_id);
        return view('orders.show',compact('order','payment_status','payment_mode','order_status','items','user'));
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

    public function change_payment_status($order_id ,$id){
       Order::where('id',$order_id)->update(['payment_status' => $id]);
       return redirect()->back()->with('Payment status update successfully');
    }

    public function change_payment_mode($order_id ,$id){
        Order::where('id',$order_id)->update(['payment_mode' => $id]);
        return redirect()->back()->with('Payment mode update successfully');
     }

    public function change_order_status($order_id ,$id){
        Order::where('id',$order_id)->update(['order_status' => $id]);
        return redirect()->back()->with('Order status update successfully');
    }

}
