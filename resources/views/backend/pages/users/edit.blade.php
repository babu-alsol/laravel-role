
@extends('backend.layouts.master')

@section('title')
User Edit - Admin Panel
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-check-label {
        text-transform: capitalize;
    }

    select {
    height: 40px !important;
    padding: 6px 25px !important;
}
</style>
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">User Edit</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.users.index') }}">All Users</a></li>
                    <li><span>Edit User - {{ $user->name }}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner card">
    <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapseOne">
           
            Personal Details

        </a>
    </div>
    <div id="" class="collapse show" data-parent="#accordion">
        <div class="">
            <div class="row container">
                <div class="col-md-2">
                    <label for="">Name</label>
                    @if ($user->name)
                        <p>{{ $user->name }}</p>
                    @else
                        <p>Not Provided</p>
                    @endif

                </div>

                <div class="col-md-2">
                    <label for="">Email</label>
                    @if ($user->email)
                        <p>{{ $user->email }}</p>
                    @else
                        <p>Not Provided</p>
                    @endif
                </div>

                <div class="col-md-2">
                    <label for="">Mobile</label>
                    @if ($user->mobile)
                        <p>{{ $user->mobile }}</p>
                    @else
                        <p>Not Provided</p>
                    @endif
                </div>

               

                <div class="col-md-2">
                    <label for="">Address</label>
                    @if ($user->address)
                   <p>{{$user->address}}</p>
                    @else
                        <p>Not Provided</p>
                    @endif
                </div>
               
                <div class="col-md-2">
                    <label for="">Block Status</label>
                    @if ($user->block_status)
                        <p>Block</p>
                    @else
                        <p>Unblock</p>
                    @endif
                </div>

                <div class="col-md-2">
                    <label for="">Profile Image</label>
                    @if ($user->profile_image)
                    <div>
                        <img height="50px" width="80px" src="/assets/user/profile_image/{{$user->profile_image}}" alt="">
                    </div>
                    @else
                        <p>Unblock</p>
                    @endif
                </div>
               
              
            </div>
        </div>

    </div>
</div>

<div class="main-content-inner card">
    <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapseOne">
            KYC Details

        </a>
    </div>
    <div id="" class="collapse show" data-parent="#accordion">
        <div class="">
            <div class="mt-2  container">
                <div class="mt-3 row">
                    <div class="col-md-6">
                        <label style="font-weight: 900" for="">Aadhar Number</label>
                        @if ($user->aadhar_no)
                            <p>{{ $user->aadhar_no }}</p>
                            
                        @else
                            <p>Not Provided</p>
                        @endif
    
                    </div>
    
                    <div class="col-md-6">
                        <label style="font-weight: 900" for="">Aadhar Image</label>
                        @if ($user->aadhar_image)
                        <div>
                            <img height="50px" width="80px" src="/assets/user/aadhar_image/{{$user->aadhar_image}}" alt="">
                        </div>
                      
                            
                        @else
                            <p>Not Provided</p>
                        @endif
    
                    </div>
                </div>
               

                <div class="mt-3 row">
                    <div class="col-md-6">
                        <label style="font-weight: 900" for="">Pan Card Number</label>
                        @if ($user->pan_no)
                            <p>{{ $user->pan_no }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>
    
                    <div class="col-md-6">
                        <label style="font-weight: 900" for="">Pan Card Image</label>
                        @if ($user->pan_image)
                        <div>
                            <img height="50px" width="80px" src="/assets/user/pan_image/{{$user->pan_image}}" alt="">
                        </div>
                       
                            
                        @else
                            <p>Not Provided</p>
                        @endif
    
                    </div>
                </div>

                <div class="mt-3 row">
                    <div style="font-weight: 900" class="col-md-6">
                        <label for="">Voter ID</label>
                        @if ($user->voter_id)
                            <p>{{ $user->voter_id }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>
    
                    <div style="font-weight: 900" class="col-md-6">
                        <label for="">Voter ID Image</label>
                        @if ($user->voter_id_image)
                        <div>
                            <img height="50px" width="80px" src="/assets/user/voter_id_image/{{$user->voter_id_image}}" alt="">
                        </div>
                       
                            
                        @else
                            <p>Not Provided</p>
                        @endif
    
                    </div>
    
                </div>

               
               
               
              
            </div>
        </div>

    </div>
</div>




<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit User</h4>
                    @include('backend.layouts.partials.messages')
                    
                  
                        <label for="">Block Status</label>
                        <form action="{{route('user.block', $user->id)}}" method="POST">
                            @csrf
                            <select  class="form-control" name="block_status" id="">
                                <option {{$user->block_status == 1 ? 'selected': ''}}>Block</option>
                                <option {{$user->block_status == 0 ? 'selected': ''}} class="form-control" value="0">Unblock</option>
                            </select>
                            <button type="submit" class="mt-2 btn btn-danger w-100">Save</button>
                        </form>
                   
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>
@endsection