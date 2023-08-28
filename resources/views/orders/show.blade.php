


@extends('layouts.app')

@section('content')

 <!-- BEGIN: Content-->
 <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Order</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders </a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ $order->order_id }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                                            {{$error}}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endforeach
            @endif

                <!-- Basic multiple Column Form section start -->
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    {{-- <h4 class="card-title"></h4> --}}
                                </div>
                                <div class="card-body row">

                                    <div class="col-md-5" >
                                        <div class="row"> 
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                Order ID : <strong>{{ $order->order_id }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                 Name : <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-12">
                                                <div class="mb-1">
                                                Last Name : <strong> Jangid</strong>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                Email : <strong> {{ $user->email }}</strong>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                Mobile : <strong> {{ $user->mobile }}</strong>
                                                </div>
                                            </div>
    
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                City : <strong> {{ $user->city }}</strong>
                                                </div>
                                            </div>
    
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                Address : <strong> {{ $order->address }}</strong>
                                                </div>
                                            </div>
    
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                Order Status : 
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ $order->order_status   }}
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @foreach ($order_status as $item)
                                                        <a class="dropdown-item" href="{{ route('change_order_status',['order_id' => $order->id, 'id' => $item->id]) }}" onclick="return confirm('Are you sure you want to change the order status?')">{{ $item->name }}</a>    
                                                        @endforeach
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
    
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                Payment Status : 
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ $order->payment_status }}
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @foreach ($payment_status as $item)
                                                            <a class="dropdown-item" href="{{ route('change_payment_status',['order_id' => $order->id, 'id' => $item->id]) }}" onclick="return confirm('Are you sure you want to change the payment status?')">{{ $item->name }}</a>    
                                                        @endforeach
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
    
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                Payment Mode : 
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ $order->payment_mode }}
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @foreach ($payment_mode as $item)
                                                            <a class="dropdown-item" href="{{ route('change_payment_mode',['order_id' => $order->id, 'id' => $item->id]) }}" onclick="return confirm('Are you sure you want to change the payment mode?')">{{ $item->name }}</a>    
                                                        @endforeach
                                                        
                                                    </div>
                                                </div>
                                                </div>
                                            </div>

                                        </div>          
                                    </div>

                                    <div class="col-md-7 " style="border-left: 2px solid #ebe9f1 !important;">
                                        <label for="">Items</label>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sr.no</th>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1;  @endphp
                                                @foreach ($items as $item)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <span class="fw-bold">{{ $item->product_name }}</span>
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                    </tr>    
                                                @php $i++ @endphp                                                    
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>


                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Floating Label Form section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection