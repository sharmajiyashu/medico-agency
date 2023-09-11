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

    public function import(Request $request){
        
        $validated = $request->validate([
            'csv_file' => 'required',
        ]);
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $filename = 'subscriptions'.time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

            $total = $this->insertData($filename);

            return redirect()->back()->with('success',$total.' product import SuccessFully');
        }

        return redirect()->back()->with('error',' Subscriber Import Failour');

    }

    private function insertData($filename)
    {
        $file = public_path('uploads/' . $filename);
        $csvData = array_map('str_getcsv', file($file));
        $csvHeader = $csvData[0]; // Assuming the first row contains header names

        $total_subscriber_insert = 0;

        foreach ($csvData as $key => $row) {
            if ($key === 0) continue; // Skip the header row
            $length = count($row);
            
            if($length == 1){
                echo $row[0];
                $check = Product::where('name',$row[0])->count();
                if($check < 1){
                    Product::create(['name' => $row[0]]);
                    $total_subscriber_insert ++;
                }
            }


        }
        return $total_subscriber_insert;
    }
}
