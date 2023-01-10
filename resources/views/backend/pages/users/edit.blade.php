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
                            <p>{{ $user->address }}</p>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>


                    <div class="col-md-2">
                        <label for="">Profile Image</label>
                        @if ($user->profile_image)
                            <div>
                                <img height="50px" width="80px"
                                    src="/assets/user/profile_image/{{ $user->profile_image }}" alt="">
                            </div>
                        @else
                            <p>Not Provided</p>
                        @endif
                    </div>

                    <div class="col-md-2">
                        <label for="">Block Status</label>
                        <input type="hidden" id="user-id" value="{{ $user->id }}">
                        <form>
                            @csrf
                            <div style="display: inline">
                                <select class="form-control" name="block_status" id="user-block">
                                    <option value="1" {{ $user->block_status == 1 ? 'selected' : '' }}>Block</option>
                                    <option value="0" {{ $user->block_status == 0 ? 'selected' : '' }}>Unblock
                                    </option>
                                    <option value="2" {{ $user->block_status == 2 ? 'selected' : '' }}>Hold</option>
                                </select>
                                {{-- <button type="submit" class="mt-2 btn btn-danger ">Save</button> --}}
                            </div>

                        </form>
                        <div id="block-message">
                            <p class=""></p>
                        </div>

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
                        @if ($bank)
                            <div class="col-md-3">
                                <label style="font-weight: 900" for="">Account Holder Name</label>
                                @if ($bank->account_holder_name)
                                    <p>{{ $bank->account_holder_name }}</p>
                                @else
                                    <p>Not Provided</p>
                                @endif

                            </div>

                            <div class="col-md-3">
                                <label style="font-weight: 900" for="">Bank Name</label>
                                @if ($bank->bank_name)
                                    <p>{{ $bank->bank_name }}</p>
                                @else
                                    <p>Not Provided</p>
                                @endif

                            </div>

                            <div class="col-md-3">
                                <label style="font-weight: 900" for="">Bank Name</label>
                                @if ($bank->account_no)
                                    <p>{{ $bank->account_no }}</p>
                                @else
                                    <p>Not Provided</p>
                                @endif

                            </div>

                            <div class="col-md-3">
                                <label style="font-weight: 900" for="">Bank Name</label>
                                @if ($bank->ifsc)
                                    <p>{{ $bank->ifsc }}</p>
                                @else
                                    <p>Not Provided</p>
                                @endif

                            </div>
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
                                    <img height="50px" width="80px"
                                        src="/assets/user/aadhar_image/{{ $user->aadhar_image }}" alt="">
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
                                    <img height="50px" width="80px" src="/assets/user/pan_image/{{ $user->pan_image }}"
                                        alt="">
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
                                    <img height="50px" width="80px"
                                        src="/assets/user/voter_id_image/{{ $user->voter_id_image }}" alt="">
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
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">All Transactions</h4>
                        @if ($transactions->count() > 0)
                            {{-- <p class="float-right mb-2">
                    <a class="btn btn-primary text-white" href="{{route('export-contacts', $user_contact->id)}}">Exports</a>
                </p> --}}
                        @endif


                        <div class="clearfix"></div>
                        <div class="data-tables">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable2" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="">Sl</th>
                            

                                        <th width="">Amount</th>
                                        <th width="">Transaction type</th>
                                        <th>Payment Type</th>

                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                        
                                            <td>{{ $data->amount }}</td>
                                            <td>{{ $data->tns_type }}</td>
                                            <td>{{ $data->payment_type }}</td>
                                           

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
    
    <div class="main-content-inner">

        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">Cashbook Entrys</h4>
                        @if ($cashbooks->count() > 0)
                            {{-- <p class="float-right mb-2">
                    <a class="btn btn-primary text-white" href="{{route('export-contacts', $user_contact->id)}}">Exports</a>
                </p> --}}
                        @endif


                        <div class="clearfix"></div>
                        <div class="data-tables">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable1" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="">Sl</th>
                                        <th width="">Date Time</th>

                                        <th width="">Amount</th>
                                        <th width="">Transaction type</th>
                                        <th width="">Payment Type</th>

                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashbooks as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ date('d-M-Y', strtotime($data->date_time)); }}</td>
                                            <td>{{ $data->amount }}</td>
                                            <td>{{ $data->cb_tns_type }}</td>
                                            <td>{{ $data->payment_type }}</td>
                                           


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

    <div class="main-content-inner">

        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">Rent Owners</h4>
                        @if ($rent_owners->count() > 0)
                            {{-- <p class="float-right mb-2">
                    <a class="btn btn-primary text-white" href="{{route('export-contacts', $user_contact->id)}}">Exports</a>
                </p> --}}
                        @endif


                        <div class="clearfix"></div>
                        <div class="data-tables">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable3" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="">Sl</th>
                                        <th width="">Name</th>

                                        <th width="">Mobile</th>
                                        <th width="">Type</th>
                                     
                                      
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rent_owners as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                          
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->mobile }}</td>
                                            <td>{{ $data->rent_type }}</td>
                                           


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

        var userId = $('#user-id').val();

        $('#user-block').on('change', function(e) {
            var block_status = e.target.value

            $.ajax({
                url: `/admin/user-block/${userId}`,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    block_status: block_status

                },
                success: function(response) {
                    console.log(response);
                    if (response.user_status == 0) {
                        $('#block-message').show()
                        $('#block-message').removeClass('text-danger')
                        $('#block-message').removeClass('text-warning')
                        $('#block-message').addClass('text-success')
                        $('#block-message').html('User Unblocked')
                        setTimeout(function() {
                            $('#block-message').fadeOut('fast');
                        }, 2000);
                    } else if (response.user_status == 1) {
                        $('#block-message').show()
                        $('#block-message').removeClass('text-success')
                        $('#block-message').removeClass('text-warning')
                        $('#block-message').addClass('text-danger')
                        $('#block-message').html('User Blocked')
                        setTimeout(function() {
                            $('#block-message').fadeOut('fast');
                        }, 2000);
                    } else {
                        $('#block-message').show()
                        $('#block-message').removeClass('text-success')
                        $('#block-message').removeClass('text-danger')
                        $('#block-message').addClass('text-warning')
                        $('#block-message').html('User Hold')
                        setTimeout(function() {
                            $('#block-message').fadeOut('fast');
                        }, 2000);
                    }

                    // $('#pilotErrorMsg').hide();

                },

            });
        });
    </script>
@endsection
