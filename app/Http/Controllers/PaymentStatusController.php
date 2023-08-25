<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentStatusRequest;
use App\Models\PaymentStatus;
use Illuminate\Http\Request;

class PaymentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_status = PaymentStatus::orderBy('id','desc')->get();
        return view('payment-status.index',compact('payment_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment-status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentStatusRequest $request)
    {
        $data = $request->validated();
        // if($request->status == 1){
        //     $data['status'] = 1;
        // }

        if($request->is_default){
            $data['is_default'] = 1;   
            PaymentStatus::where('is_default',1)->update(['is_default' => 0]);
        }
        PaymentStatus::create($data);
        return redirect()->route('payment-status.index')->with('success','Status added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentStatus $paymentStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentStatus $paymentStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentStatus $paymentStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentStatus $paymentStatus)
    {
        $paymentStatus->delete();
        return redirect()->back()->with('success','Delete payment status successfully');
    }

    public function changeStatus(Request $request){
        $payment_status = PaymentStatus::where('id',$request->id)->first();
        if($payment_status->status == PaymentStatus::$active){
            $payment_status->update(['status' => PaymentStatus::$inactive]);
            return json_encode(['0' ,'Status Inactive Successfully']);
        }else{
            $payment_status->update(['status' => PaymentStatus::$active]);
            return json_encode(['1' ,'Status Active Successfully']);
        }
    }

    public function changeDefaultto ($id){
        PaymentStatus::where('is_default', '1')->update(['is_default' => '0']);
        PaymentStatus::where('id',$id)->update(['is_default' => '1']);
        return redirect()->back()->with('success','Default payment successfuly');
    }


}
