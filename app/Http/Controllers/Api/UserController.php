<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetOrderDetailRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\userLoginRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\PaymentMode;
use App\Models\PaymentStatus;
use App\Models\Product;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class UserController extends Controller
{
    use ApiResponse;
    public function login(userLoginRequest $request){

        if (!Auth::attempt($request->validated())) {
            return $this->sendFailed('The provided credentials do not match our records.',200);
        }
        $user = $request->user();
        $token = $user->createToken($user->mobile)->plainTextToken;
        $token = explode('|',$token)[1];
        $user['accessToken'] = $token;
        $user->image = asset('public/images/users/'.$request->user()->image);
        return $this->sendSuccess('Successfully logged in',$user);
    }

    public function getProfile(Request $request){
        $request->user()->image = asset('public/images/users/'.$request->user()->image);
        return $this->sendSuccess('Profile fetch successfully',$request->user());
    }

    public function products(Request $request){
        $products = Product::where('status',Product::$active)->orderBy('id','desc')->get();
        return $this->sendSuccess('Products fetch successfully',$products);
    }

    public function createOrder(Request $request){
        $products = $request->all();
        $order_data = [
            'order_id' => self::GenerateOrderID(),
            'user_id' => $request->user()->id,
            'payment_status' => isset(PaymentStatus::where('is_default','1')->first()->id) ? PaymentStatus::where('is_default','1')->first()->id :'',
            'payment_mode' => isset(PaymentMode::where('is_default','1')->first()->id) ? PaymentMode::where('is_default','1')->first()->id :'',
            'order_status' => isset(OrderStatus::where('is_default','1')->first()->id) ? OrderStatus::where('is_default','1')->first()->id :'',
            'address' => $request->user()->address,
        ];
        $order = Order::create($order_data);
        $order->payment_status = isset(PaymentStatus::find($order->payment_status)->name) ? PaymentStatus::find($order->payment_status)->name :'';
        $order->payment_mode = isset(PaymentMode::find($order->payment_mode)->name) ? PaymentMode::find($order->payment_mode)->name :'';
        $order->order_status = isset(OrderStatus::find($order->order_status)->name) ? OrderStatus::find($order->order_status)->name :'';
        $items = 0;
        foreach($products as $key=>$val){
            $check = Product::where('id',$val['product_id'])->where('status',Product::$active)->count();
            if($check > 0 && $val['quantity'] > 0){
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $val['product_id'],
                    'quantity' => $val['quantity'],
                ]);
            }
        }
        $items = OrderItem::where('order_id',$order->id)->get()->map(function($items){
            $items->product_name = isset(Product::find($items->product_id)->name) ? Product::find($items->product_id)->name :'';
            return $items;
        });
        return $this->sendSuccess('Order create successfully',['order_detail' => $order ,'order_items' => $items]);
    }

    function GenerateOrderID(){
        $store_code = 'MA'.mt_rand(10000000, 99999999);
        if(Order::where('order_id',$store_code)->first()){
            $this->GenerateOrderID();
        }else{
            return $store_code;
        }
    }

    public function orders(Request $request){
        $orders = Order::where('user_id',$request->user()->id)->orderBy('id','desc')->get()->map(function($order){
            $order->payment_status = isset(PaymentStatus::find($order->payment_status)->name) ? PaymentStatus::find($order->payment_status)->name :'';
            $order->payment_mode = isset(PaymentMode::find($order->payment_mode)->name) ? PaymentMode::find($order->payment_mode)->name :'';
            $order->order_status = isset(OrderStatus::find($order->order_status)->name) ? OrderStatus::find($order->order_status)->name :'';
            $items = OrderItem::select('product_id','quantity')->where('order_id',$order->id)->get()->map(function($items){
                $items->product_name = isset(Product::find($items->product_id)->name) ? Product::find($items->product_id)->name :'';
                return $items;
            });
            $order->items = $items;
            return $order;
        });
        return $this->sendSuccess('Orders Fetch successfully',$orders);
    }    

    public function orderDetail(GetOrderDetailRequest $request){
        $order = Order::find($request->order_id);
        $order->payment_status = isset(PaymentStatus::find($order->payment_status)->name) ? PaymentStatus::find($order->payment_status)->name :'';
        $order->payment_mode = isset(PaymentMode::find($order->payment_mode)->name) ? PaymentMode::find($order->payment_mode)->name :'';
        $order->order_status = isset(OrderStatus::find($order->order_status)->name) ? OrderStatus::find($order->order_status)->name :'';
        $items = OrderItem::where('order_id',$order->id)->get()->map(function($items){
            $items->product_name = isset(Product::find($items->product_id)->name) ? Product::find($items->product_id)->name :'';
            return $items;
        });
        return $this->sendSuccess('Order detail fetch successfully',['order_detail' => $order ,'order_items' => $items]);
    }

    public function updateProfile(UpdateProfileRequest $request){
        $data  = $request->validated();
        if($request->hasFile('image')) {
            $image_name = time().rand(1,100).'-'.$request->image->getClientOriginalName();
            $image_name = preg_replace('/\s+/', '', $image_name);
            $request->image->move(public_path('images/users'), $image_name);
            $data['image'] = $image_name;
        }
        User::where('id',$request->user()->id)->update($data);

        $user = User::find($request->user()->id);
        $user->image = asset('public/images/users/'.$request->user()->image);
        return $this->sendSuccess('Profile update successfully',$user);
    }

}