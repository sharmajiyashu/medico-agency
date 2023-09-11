@extends('layouts.app')
@section('content')

<!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row match-height">

                        <!-- Statistics Card -->
                        <div class="col-xl-12 col-md-6 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Statistics</h4>
                                    <div class="d-flex align-items-center">
                                        {{-- <p class="card-text font-small-2 me-25 mb-0">Updated 1 month ago</p> --}}
                                    </div>
                                </div>
                                <div class="card-body statistics-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-primary me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="box" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">{{ $products }}</h4>
                                                    <p class="card-text font-small-3 mb-0"><a href="{{ route('products.index') }}">Products</a></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-info me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="user" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">{{ $users }}</h4>
                                                    <p class="card-text font-small-3 mb-0"><a href="{{ route('users.index') }}">Users</a></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6 col-12 mb-2 mb-sm-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="shopping-cart" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">{{ $orders }}</h4>
                                                    <p class="card-text font-small-3 mb-0"><a href="{{ route('orders.index') }}">Orders</a></p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        <!--/ Statistics Card -->
                    </div>

                    <section id="ajax-datatable">
                        <div class="row">
                            <div class="col-7">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">New Orders (Top 10 Orders)</h4>
                                        {{-- <a href="{{route('orders.create')}}" class=" btn btn-primary btn-gradient round  ">Add User</a> --}}
                                    </div>
                                    <div class="card-datatable">
                                        <table class="datatables-ajax table table-responsive ">
    
                                            
                                            <thead>
                                                {{-- <tr> --}}
                                                    {{-- <th>Sr.no</th> --}}
                                                    {{-- <th>Order ID</th> --}}
                                                    {{-- <th>Name</th> --}}
                                                    {{-- <th>Mobile</th> --}}
                                                    {{-- <th>Order status</th> --}}
                                                    {{-- <th>Payment status</th> --}}
                                                    {{-- <th>PAyment Mode</th> --}}
                                                    {{-- <th>City</th> --}}
                                                    {{-- <th>Items count</th> --}}
                                                    {{-- <th>Created Date</th> --}}
                                                    {{-- <th>Action</th> --}}
                                                {{-- </tr> --}}
                                            </thead>
                                            <tbody>
                                                @php  $i=1; @endphp
                                                @foreach($orders_item as $key => $val)
                                                <tr>
                                                    <th scope="row">{{ $i }}</th>
                                                    <td><a href="{{ route('orders.show',$val->id) }}"><strong>{{ $val->order_id }}</strong></a></td>
                                                    <td><strong>{{ $val->name }}</strong></td>
                                                    <td>{{ $val->mobile }}</td>
                                                    {{-- <td>{{ $val->order_status }}</td> --}}
                                                    {{-- <td>{{ $val->payment_status }}</td> --}}
                                                    {{-- <td>{{ $val->payment_mode }}</td> --}}
                                                    {{-- <td>{{ $val->city }}</td> --}}
                                                    <td>{{ $val->items }}</td>
                                                    {{-- <td>{{ date('d-M-y H:i:s',strtotime($val->created_at)) }}</td> --}}
                                                    <td>
                                                        <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#danger_ke{{ $val->id }}"><button class="btn btn-danger">Delete</button></a>
    
                                                        <!-- Modal -->
                                                        <div class="modal fade modal-danger text-start" id="danger_ke{{ $val->id }}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="myModalLabel120">Delete Category</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
    
                                                                            @if ($val->is_default == 1)
                                                                                This is set on default, please set another to default  
                                                                            @else
                                                                                Are you sure you want to delete !
                                                                            @endif 
                                                                                
                                                                        </div>
                                                                        @if ($val->is_default != 1)
                                                                        <form action="{{route('orders.destroy',$val->id)}}" method="POST">
                                                                            @endif 
                                                                            @csrf
                                                                            @method('delete')
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-danger" @if ($val->is_default == 1) @disabled(true) @endif>Delete</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php $i++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Today Orders </h4>
                                        {{-- <a href="{{route('orders.create')}}" class=" btn btn-primary btn-gradient round  ">Add User</a> --}}
                                    </div>
                                    <div class="card-datatable">
                                        <table class="datatables-ajax table table-responsive ">
    
                                            
                                            <thead>
                                                 {{-- <tr>
                                                    <th>Sr.no</th>
                                                    <th>Order ID</th>
                                                    <th>Name</th> --}}
                                                    {{-- <th>Mobile</th> --}}
                                                    {{-- <th>Order status</th> --}}
                                                    {{-- <th>Payment status</th> --}}
                                                    {{-- <th>PAyment Mode</th> --}}
                                                    {{-- <th>City</th> --}}
                                                    {{-- <th>Items count</th> --}}
                                                    {{-- <th>Created Date</th> --}}
                                                    {{-- <th>Action</th> --}}
                                                {{-- </tr> -->> --}}
                                            </thead>
                                            <tbody>
                                                @php  $i=1; @endphp
                                                @foreach($orders_today as $key => $val)
                                                <tr>
                                                    <th scope="row">{{ $i }}</th>
                                                    <td><a href="{{ route('orders.show',$val->id) }}"><strong>{{ $val->order_id }}</strong></a></td>
                                                    <td><strong>{{ $val->name }}</strong></td>
                                                    {{-- <td>{{ $val->mobile }}</td> --}}
                                                    {{-- <td>{{ $val->order_status }}</td> --}}
                                                    {{-- <td>{{ $val->payment_status }}</td> --}}
                                                    {{-- <td>{{ $val->payment_mode }}</td> --}}
                                                    {{-- <td>{{ $val->city }}</td> --}}
                                                    <td>{{ $val->items }}</td>
                                                    {{-- <td>{{ date('d-M-y H:i:s',strtotime($val->created_at)) }}</td> --}}
                                                    {{-- <td>
                                                        <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#danger_ke{{ $val->id }}"><button class="btn btn-danger">Delete</button></a>
    
                                                        <!-- Modal -->
                                                        <div class="modal fade modal-danger text-start" id="danger_ke{{ $val->id }}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="myModalLabel120">Delete Category</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
    
                                                                            @if ($val->is_default == 1)
                                                                                This is set on default, please set another to default  
                                                                            @else
                                                                                Are you sure you want to delete !
                                                                            @endif 
                                                                                
                                                                        </div>
                                                                        @if ($val->is_default != 1)
                                                                        <form action="{{route('orders.destroy',$val->id)}}" method="POST">
                                                                            @endif 
                                                                            @csrf
                                                                            @method('delete')
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-danger" @if ($val->is_default == 1) @disabled(true) @endif>Delete</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                                @php $i++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                    </section>


                    <section id="ajax-datatable">
                        <div class="row">
                           
                        </div>
                    </section>
    

                   
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection