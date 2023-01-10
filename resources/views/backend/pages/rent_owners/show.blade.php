@extends('backend.layouts.master')

@section('title')
    User Edit - Admin Panel
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
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
                    <h4 class="page-title pull-left">Show Rent Owner</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.rent-owners.index') }}">All Rent Owners</a></li>
                        <li><span>Edit Rent Owner - {{ $rentOwner->name }}</span></li>
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
                    <div class="col-md-3">
                        <label for="">Name</label>
                        @if ($rentOwner->name)
                            <p>{{ $rentOwner->name }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif

                    </div>

                    <div class="col-md-3">
                        <label for="">Email</label>
                        @if ($rentOwner->email)
                            <p>{{ $rentOwner->email }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label for="">Mobile</label>
                        @if ($rentOwner->mobile)
                            <p>{{ $rentOwner->mobile }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>



                    <div class="col-md-3">
                        <label for="">Address</label>
                        @if ($rentOwner->address)
                            <p>{{ $rentOwner->address }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>


    <div class="main-content-inner card">
        <div class="card-header">
            <a class="card-link" data-toggle="collapse" href="#collapseOne">
                Bank Details

            </a>
        </div>
        <div id="" class="collapse show" data-parent="#accordion">
            <div class="">
                <div class="mt-2  container">
                    <div class="mt-3 row">
                      
                            <div class="col-md-3">
                                <label style="font-weight: 900" for="">Account Holder Name</label>
                                @if ($rentOwner->account_holder_name)
                                    <p>{{ $rentOwner->account_holder_name }}</p>
                                @else
                                    <p>Not Provided</p>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label style="font-weight: 900" for="">Bank Name</label>
                                @if ($rentOwner->bank_name)
                                    <p>{{ $rentOwner->bank_name }}</p>
                                @else
                                    <p>Not Provided</p>
                                @endif

                            </div>

                            <div class="col-md-3">
                                <label style="font-weight: 900" for="">Bank Name</label>
                                @if ($rentOwner->account_no)
                                    <p>{{ $rentOwner->account_no }}</p>
                                @else
                                    <p>Not Provided</p>
                                @endif

                            </div>

                            <div class="col-md-3">
                                <label style="font-weight: 900" for="">Bank Name</label>
                                @if ($rentOwner->ifsc_code)
                                    <p>{{ $rentOwner->ifsc_code }}</p>
                                @else
                                    <p>Not Provided</p>
                                @endif

                            </div>
                       

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
                    <div class="mt-6 row">
                        <div class="col-md-6">
                            <label style="font-weight: 900" for="">Pan Number</label>
                            @if ($rentOwner->pan_no)
                                <p>{{ $rentOwner->pan_no }}</p>
                            @else
                                <p>Not Provided</p>
                            @endif

                        </div>

                        <div class="col-md-6">
                            <label style="font-weight: 900" for="">Pan Image</label>
                            @if ($rentOwner->pan_image)
                                <div>
                                    <img height="50px" width="80px"
                                        src="/assets/rent/pan/{{ $rentOwner->pan_image }}" alt="">
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


   
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        if ($('#dataTable2').length) {
            $('#dataTable2').DataTable({
                responsive: true
            });
        }


        if ($('#dataTable1').length) {
            $('#dataTable1').DataTable({
                responsive: true
            });
        }

        if ($('#dataTable3').length) {
            $('#dataTable3').DataTable({
                responsive: true
            });
        }

        $(document).ready(function() {
            $('.select2').select2();
        })

       
    </script>
@endsection
