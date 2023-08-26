
@extends('layouts.app')

@section('content')

<style>
    .Active{
        color: green;
        font-weight: 900;
    }
    .Inactive{
        color: red;
        font-weight: 900;
    }
</style>

 <!-- BEGIN: Content-->
<!-- BEGIN: Content-->
<div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Payment Status</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('master.payment-status.index') }}">Payment Status</a>
                                    </li>
                                    <li class="breadcrumb-item active">List
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Ajax Sourced Server-side -->
                <section id="ajax-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">List</h4>
                                    <a href="{{route('master.payment-status.create')}}" class=" btn btn-primary btn-gradient round  ">Add Status</a>
                                </div>
                                <div class="card-datatable">
                                    <table class="datatables-ajax table table-responsive datatable_data">

                                        <script>
                                            function ChangeStatusActive (id){
                                                $.ajax({
                                                    url: "{{ route('master.payment-status.change_status') }}",
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {
                                                        _token: "{{ csrf_token() }}",id:id
                                                    },
                                                    success: function(response){
                                                        console.log(response[0]);
                                                        if(response[0] == 1){
                                                            toastr.success(response[1]);
                                                        }else{
                                                            toastr.error(response[1]);
                                                        }
                                                    }
                                                });
                                            }

                                            function ChangeISDefaultTo(id,name){
                                                var result = confirm("Are you sure you want to set default to "+name+" ?");
                                                if (result) {
                                                    window.location.href = "{{ route('master.payment_status.change_default_to', ':id') }}".replace(':id', id);
                                                } else {
                                                    
                                                }
                                            }
                                        </script>
                                        <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>Name</th>
                                                <th>status</th>
                                                <th>Is Default</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php  $i=1; @endphp
                                            @foreach($payment_status as $key => $val)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td><strong>{{ $val->name }}</strong></td>
                                                <td><div class="form-check form-check-primary form-switch">
                                                        <input class="form-check-input checked_chackbox" id="systemNotification" type="checkbox" name="is_default" onclick="ChangeStatusActive({{ $val->id }})" @if ($val->status == 1)
                                                            @checked(true) 
                                                        @endif   @if ($val->is_default == 1)
                                                            @disabled(true)
                                                        @endif  value="1" >
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="form-check form-check-primary form-switch">
                                                        <input class="form-check-input checked_chackbox" id="systemNotification" type="checkbox" name="is_default"  value="1" onclick="ChangeISDefaultTo({{ $val->id }}, '{{ $val->name}}')" @if ($val->is_default == 1)
                                                        @checked(true) 
                                                    @endif >
                                                    </div>

                                                </td>
                                                <td>{{ date('d-M-y H:i:s',strtotime($val->created_at)) }}</td>
                                                <td>
                                                    <a  href="{{route('master.payment-status.edit',$val->id)}}">
                                                        <button class="btn btn-info">Edit</button>
                                                    </a>

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
                                                                    <form action="{{route('master.payment-status.destroy',$val->id)}}" method="POST">
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
                    </div>
                </section>

                <!--/ Ajax Sourced Server-side -->

                

            </div>
        </div>
    </div>
    <!-- END: Content-->
    <!-- END: Content-->

@endsection