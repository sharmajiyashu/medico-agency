<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('dashboard',compact('products','orders','users'));
    }


}
