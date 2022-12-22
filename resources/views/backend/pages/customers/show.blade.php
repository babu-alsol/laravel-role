@extends('backend.layouts.master')

@section('title')
    Customers - Admin Panel
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
                    <h4 class="page-title pull-left">Customers</h4>
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
                Customer Details

            </a>
        </div>
        <div id="" class="collapse show" data-parent="#accordion">
            <div class="">
                <div class="row container">
                    <div class="col-md-2">
                        <label for="">Name</label>
                        @if ($customer->cus_name)
                            <p>{{ $customer->cus_name }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif

                    </div>

                    <div class="col-md-2">
                        <label for="">Email</label>
                        @if ($customer->cus_email)
                            <p>{{ $customer->cus_email }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>

                    <div class="col-md-2">
                        <label for="">Mobile</label>
                        @if ($customer->cus_mobile)
                            <p>{{ $customer->cus_mobile }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <label for="">Bank Account Number</label>
                        @if ($customer->bank_account_no)
                            <p>{{ $customer->bank_account_no }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <label for="">Address</label>
                        @if ($customer->cus_address)
                            <p>{{ $customer->cus_address }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
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
                        <h4 class="header-title float-left"></h4>
                        @if ($transactions->count() > 0)
                            {{-- <p class="float-right mb-2">
                        <a class="btn btn-primary text-white" href="{{route('export-contacts', $user_contact->id)}}">Exports</a>
                    </p> --}}
                        @endif


                        <div class="clearfix"></div>
                        <div class="data-tables">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="">Sl</th>

                                        <th width="">Amount</th>
                                        <th width="">Transaction_type</th>
                                        <th width="">Bill No</th>

                                        <th style="display: none" width="">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>

                                            <td>{{ $data->amount }}</td>
                                            <td>{{ $data->tns_type }}</td>
                                            <td>{{ $data->bill_no }}</td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->

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

