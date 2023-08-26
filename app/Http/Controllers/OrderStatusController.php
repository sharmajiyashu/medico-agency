<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderStatusRequest;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_status = OrderStatus::orderBy('id','desc')->get();
        return view('order-status.index',compact('order_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('order-status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderStatusRequest $request)
    {
        $data = $request->validated();
        if($request->is_default){
            $data['is_default'] = '1';   
            OrderStatus::where('is_default','1')->update(['is_default' => '0']);
        }
        OrderStatus::create($data);
        return redirect()->route('master.order-status.index')->with('success','Order status added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function show(OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderStatus $orderStatus)
    {
        return view('order-status.edit',compact('orderStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderStatus $orderStatus)
    {
        $check = OrderStatus::where('id','!=',$orderStatus->id)->where('name',$request->name)->count();
        if($check > 0){
            return back()->withErrors([
                'email' => 'The name has already been taken.',
            ])->onlyInput('email');
        }
        $orderStatus->update($request->all());
        return redirect()->route('master.order-status.index')->with('success','Order status update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderStatus $orderStatus)
    {
        $orderStatus->delete();
        return redirect()->route('master.order-status.index')->with('success','Order status delete successfully');
    }

    public function changeStatus(Request $request){
        $payment_status = OrderStatus::where('id',$request->id)->first();
        if($payment_status->status == OrderStatus::$active){
            $payment_status->update(['status' => OrderStatus::$inactive]);
            return json_encode(['0' ,'Status Inactive Successfully']);
        }else{
            $payment_status->update(['status' => OrderStatus::$active]);
            return json_encode(['1' ,'Status Active Successfully']);
        }
    }

    public function changeDefaultto ($id){
        OrderStatus::where('is_default', '1')->update(['is_default' => '0']);
        OrderStatus::where('id',$id)->update(['is_default' => '1']);
        return redirect()->back()->with('success','Default payment successfuly');
    }
}
