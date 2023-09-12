<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::role(User::$role_user)->orderBy('id','desc')->get()->map(function($user){
            $user->gen_id = $encript_data = Crypt::encryptString($user->id);
            return $user;
        });
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $emailParts = explode('@', $request->email);
        $username = $emailParts[0];
        $data  = $request->validated();
        if($request->hasFile('image')) {
            $image_name = time().rand(1,100).'-'.$request->image->getClientOriginalName();
            $image_name = preg_replace('/\s+/', '', $image_name);
            $request->image->move(public_path('images/users'), $image_name);
            $data['image'] = $image_name;
        }
        $data['user_name'] = $username;
        $data['role'] = 2;
        $data['password'] = Hash::make($request->password);
        User::create($data);
        return redirect()->route('users.index')->with('success','User create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        
        $email_count = user::where('email',$request->email)->whereNot('id',$user->id)->count();
        if($email_count > 0){
            return redirect()->back()->with('error','Email is already has been taken');
        }
        $mobile_count = user::where('mobile',$request->mobile)->whereNot('id',$user->id)->count();
        if($mobile_count > 0){
            return redirect()->back()->with('error','Mobile is already has been taken');
        }
        $user->update($request->all());
        return redirect()->route('users.index')->with('success','User update sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        $user->update(['email' => '']);
        return redirect()->back()->with('success','User delete successfully');
    }

    public function changeStatus(Request $request){
        $payment_status = User::where('id',$request->id)->first();
        if($payment_status->status == User::$active){
            $payment_status->update(['status' => User::$inactive]);
            return json_encode(['0' ,'Status Inactive Successfully']);
        }else{
            $payment_status->update(['status' => User::$active]);
            return json_encode(['1' ,'Status Active Successfully']);
        }
    }

    
}
