<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id','desc')->get();
        return view('products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        Product::create($data);
        return redirect()->route('products.index')->with('success','Product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $check = Product::where('id','!=',$product->id)->where('name',$request->name)->count();
        if($check > 0){
            return back()->withErrors([
                'email' => 'The name has already been taken.',
            ])->onlyInput('email');
        }
        $product->update($request->all());
        return redirect()->route('products.index')->with('success','Product update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Product delete successfully');
    }

    public function changeStatus(Request $request){
        $payment_status = Product::where('id',$request->id)->first();
        if($payment_status->status == Product::$active){
            $payment_status->update(['status' => Product::$inactive]);
            return json_encode(['0' ,'Status Inactive Successfully']);
        }else{
            $payment_status->update(['status' => Product::$active]);
            return json_encode(['1' ,'Status Active Successfully']);
        }
    }
}
