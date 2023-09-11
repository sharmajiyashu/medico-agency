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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LoginController extends Controller
{
    function index (){
        return view('auth.login');
    }

    function check_login(Request $request){
        $credentials = $request->validate([
            'email' => [
                'required',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)
                        ->where('role', 1)
                        ->first();
            
                    if (!$user) {
                        $fail('The selected email is invalid.');
                    }
                },
            ],
            'password' => ['required'],
        ]);
       
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout (){
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard(){
        $products = Product::count();
        $users = User::role(User::$role_user)->count();
        $orders = Order::count();
        $orders_item = Order::latest()->limit(10)->get()->map(function($order){
            $order->name = User::find($order->user_id)->first_name.''.User::find($order->user_id)->last_name;
            $order->mobile = User::find($order->user_id)->mobile;
            $order->city = User::find($order->user_id)->city;
            $order->email = User::find($order->user_id)->email;
            $order->payment_status = isset(PaymentStatus::find($order->payment_status)->name) ? PaymentStatus::find($order->payment_status)->name :'';
            $order->payment_mode = isset(PaymentMode::find($order->payment_mode)->name) ? PaymentMode::find($order->payment_mode)->name :'';
            $order->order_status = isset(OrderStatus::find($order->order_status)->name) ? OrderStatus::find($order->order_status)->name :'';
            $order->items = OrderItem::where('order_id',$order->id)->count();
            return $order;
        });;
        $currentDate = Carbon::now()->toDateString();
        $orders_today = Order::whereDate('created_at', $currentDate)->latest()->limit(10)->get()->map(function($order){
            $order->name = User::find($order->user_id)->first_name.''.User::find($order->user_id)->last_name;
            $order->mobile = User::find($order->user_id)->mobile;
            $order->city = User::find($order->user_id)->city;
            $order->email = User::find($order->user_id)->email;
            $order->payment_status = isset(PaymentStatus::find($order->payment_status)->name) ? PaymentStatus::find($order->payment_status)->name :'';
            $order->payment_mode = isset(PaymentMode::find($order->payment_mode)->name) ? PaymentMode::find($order->payment_mode)->name :'';
            $order->order_status = isset(OrderStatus::find($order->order_status)->name) ? OrderStatus::find($order->order_status)->name :'';
            $order->items = OrderItem::where('order_id',$order->id)->count();
            return $order;
        });;
        return view('dashboard',compact('products','orders','users','orders_item','orders_today'));
    }

    public function resetPassword($id){
        $id = Crypt::decryptString($id);
        return view('auth.reset-password',compact('id'));
    }

    public function change_password(Request $request){
        $credentials = $request->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'user_id' => 'required|exists:users,id'
        ]);
        User::where('id',$request->user_id)->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with('success','Password Change Successfully');
    }


}
