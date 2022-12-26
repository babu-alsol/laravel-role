
@extends('backend.layouts.master')

@section('title')
Dashboard Page - Admin Panel
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Dashboard</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="index.html">Home</a></li>
                    <li><span>Dashboard</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
  <div class="row">
    <div class="col-lg-12">
        <div class="mt-5 row">

          

            <div class="col-md-4 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.users.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-users"></i> Total Users</div>
                                <h2>{{ $all_users }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div> <div class="col-md-4 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.users.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-users"></i> Last Month Users</div>
                                <h2>{{ $all_users }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <a href="{{ route('admin.users.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-user"></i> New Users</div>
                                <h2>{{ $new_user}}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.transactions.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    {{-- <i class="fa fa-users"></i> --}}
                                     Total Transactions</div>
                                <h2>{{ $all_transactions }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.transactions.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    {{-- <i class="fa fa-users"></i>  --}}
                                    Last Month's Transactions</div>
                                <h2>{{ $all_transactions }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <a href="{{ route('admin.transactions.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    {{-- <i class="fa fa-user"></i>  --}}
                                    Today's Transactions</div>
                                <h2>{{ $new_transactions }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.cashbooks.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    {{-- <i class="fa fa-users"></i>  --}}
                                    Total Cashbook Entries</div>
                                <h2>{{ $all_cashbooks }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.cashbooks.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    {{-- <i class="fa fa-users"></i>  --}}
                                    Last Month's Cashbook Entries</div>
                                <h2>{{ $all_cashbooks }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <a href="{{ route('admin.cashbooks.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    {{-- <i class="fa fa-user"></i>  --}}
                                    Today's Cashbook Entries</div>
                                <h2>{{ $new_cashbooks }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.cashbooks.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    {{-- <i class="fa fa-users"></i>  --}}
                                    Total Transactions Online</div>
                                <h2>{{ $all_cashbooks }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.cashbooks.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    {{-- <i class="fa fa-users"></i>  --}}
                                    Last Transactions Online</div>
                                <h2>{{ $all_cashbooks }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <a href="{{ route('admin.cashbooks.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon">
                                    {{-- <i class="fa fa-user"></i>  --}}
                                    Today's Transactions Online</div>
                                <h2>{{ $new_cashbooks }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection