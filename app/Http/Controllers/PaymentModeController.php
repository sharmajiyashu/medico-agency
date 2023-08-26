<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentModeRequest;
use App\Models\PaymentMode;
use Illuminate\Http\Request;

class PaymentModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_mode = PaymentMode::orderBy('id','desc')->get();
        return view('payment-mode.index',compact('payment_mode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment-mode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentModeRequest $request)
    {
        $data = $request->validated();
        if($request->is_default){
            $data['is_default'] = '1';   
            PaymentMode::where('is_default','1')->update(['is_default' => '0']);
        }
        PaymentMode::create($data);
        return redirect()->route('master.payment-mode.index')->with('success','Payment mode added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentMode  $paymentMode
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMode $paymentMode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMode  $paymentMode
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMode $paymentMode)
    {
        return view('payment-mode.edit',compact('paymentMode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMode  $paymentMode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMode $paymentMode)
    {
        $check = PaymentMode::where('id','!=',$paymentMode->id)->where('name',$request->name)->count();
        if($check > 0){
            return back()->withErrors([
                'email' => 'The name has already been taken.',
            ])->onlyInput('email');
        }
        $paymentMode->update($request->all());
        return redirect()->route('master.payment-mode.index')->with('success','Payment mode update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMode  $paymentMode
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMode $paymentMode)
    {
        $paymentMode->delete();
        return redirect()->route('master.payment-mode.index')->with('success','Payment mode delete successfully');
    }

    public function changeStatus(Request $request){
        $payment_status = PaymentMode::where('id',$request->id)->first();
        if($payment_status->status == PaymentMode::$active){
            $payment_status->update(['status' => PaymentMode::$inactive]);
            return json_encode(['0' ,'Status Inactive Successfully']);
        }else{
            $payment_status->update(['status' => PaymentMode::$active]);
            return json_encode(['1' ,'Status Active Successfully']);
        }
    }

    public function changeDefaultto ($id){
        PaymentMode::where('is_default', '1')->update(['is_default' => '0']);
        PaymentMode::where('id',$id)->update(['is_default' => '1']);
        return redirect()->back()->with('success','Default payment successfuly');
    }

}
