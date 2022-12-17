@extends('backend.layouts.master')

@section('title')
    Business Show
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Business</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

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
                Business Details

            </a>
        </div>
        <div id="" class="collapse show" data-parent="#accordion">
            <div class="">
                <div class="row container">
                    <div class="col-md-3">
                        <label for="">Name</label>
                        @if ($business->bns_name)
                            <p>{{ $business->bns_name }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif

                    </div>

                    <div class="col-md-3">
                        <label for="">Owner</label>
                        @if ($business->user->name)
                            <p>{{$business->user->name }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label for="">GSTIN Number</label>
                        @if ($business->gstin_no)
                            <p>{{ $business->gstin_no }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label for="">Adress</label>
                        @if ($business->address)
                            <p>{{ $business->address}}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>
                  
                  
                </div>
            </div>

        </div>
    </div>


@endsection


@section('scripts')
    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <script>
        /*================================
            datatable active
            ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }

       
    </script>
@endsection
