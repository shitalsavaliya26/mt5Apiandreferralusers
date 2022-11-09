@extends('layouts.admin_app')
@section('title', 'All Report')
@section('content')
        <div class="content-wrapper">
            <div class="row ">
                <div class="col-md-12">
                    <h4 class="font-weight-bold">All Report</h4>
                    <div >
                        <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2 download-report" href="{{route('trading-profit-exports')}}">Trading Profit</a>
                        <a class="col-sm-12 col-lg-1 col-md-4 btn text-black btn-outline-dark mr-4 mt-2 download-report" href="{{route('unilevel-exports')}}">Unilevel</a>
                        <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2 download-report" href="{{route('profit-sharing-exports')}}">Profit Sharing</a>
                        <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2 download-report" href="{{route('leadership-exports')}}">Leadership Bonus</a>
                        <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2 download-report" href="{{route('ownership-exports')}}">Ownership Bonus</a>
                        <a class="col-sm-12 col-lg-1 col-md-4 btn text-black btn-outline-dark mr-4 mt-2 download-report" href="{{route('total-exports')}}">Total</a>
                    </div>
                    <!-- <form method="get" action="{{route('admin-all-reports')}}"> -->
                     {{Form::open(['route'=>'admin-all-reports','method'=>'get',"id"=>"report-all"])}}  
                        <div class="ml-2 mt-4 mb-2 text-right">
                            <div id="" class="input-group">
                                <div class="row col-lg-9 col-md-12 ml-auto search-field p-0">
                                    <div class="col-md-4 search-inpt">
                                        <input type="text" name="username" placeholder="Search by Username"
                                               value="{{@$data['username']}}" class="form-control">
                                    </div>
                                    <div class="col-md-4 search-inpt">
                                        <input type="text" id="date-range-my" placeholder="Select Date"
                                               value="{{@$data['start_date']?$data['start_date'].'-'.$data['end_date']:''}}" class="form-control">
                                        <input type="hidden" name="start_date" value="{{@$data['start_date']}}" id="startdate" class="form-control">
                                        <input type="hidden" name="end_date"  value="{{@$data['end_date']}}" id="enddate" class="form-control">
                                        <span class="input-group-addon input-group-append border-left"></span>
                                    </div>
                                    <div class="row col-md-4 search-action">
                                        <button type="submit"
                                                class=" btn-outline-twitter input-group-text">
                                            Search
                                        </button>&nbsp;
                                        <a href="{{route('admin-all-reports')}}" class="btn-outline-twitter input-group-text" >
                                            Reset
                                        </a>
                                        &nbsp;
                                        <!-- <a href="{{route('admin-all-reports')}}" class="btn-outline-twitter input-group-text" >
                                            Export
                                        </a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session()->get('message') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="Trading-tab" data-toggle="tab" href="#Trading-1" role="tab" aria-controls="home-1" aria-selected="true">Trading Profit</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Unilevel-tab" data-toggle="tab" href="#Unilevel-1" role="tab" aria-controls="profile-1" aria-selected="false">Unilevel</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Profit-tab" data-toggle="tab" href="#Profit-1" role="tab" aria-controls="contact-1" aria-selected="false">Profit Sharing</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Leadership-tab" data-toggle="tab" href="#Leadership-1" role="tab" aria-controls="contact-1" aria-selected="false">Leadership Bonus</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="Ownership-tab" data-toggle="tab" href="#Ownership-1" role="tab" aria-controls="contact-1" aria-selected="false">Ownership Bonus</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="total-tab" data-toggle="tab" href="#total-1" role="tab" aria-controls="contact-1" aria-selected="false">Total</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="Trading-1" role="tabpanel" aria-labelledby="home-tab">
                                @include('admin.reports.partials.trading')
                        </div>
                        <div class="tab-pane fade show" id="Unilevel-1" role="tabpanel" aria-labelledby="home-tab">
                                @include('admin.reports.partials.unilevel')
                        </div>
                        <div class="tab-pane fade show" id="Profit-1" role="tabpanel" aria-labelledby="home-tab">
                                @include('admin.reports.partials.profit')
                        </div>
                        <div class="tab-pane fade show" id="Leadership-1" role="tabpanel" aria-labelledby="home-tab">
                                @include('admin.reports.partials.leadership')
                        </div>
                        <div class="tab-pane fade show" id="Ownership-1" role="tabpanel" aria-labelledby="home-tab">
                                @include('admin.reports.partials.ownership')
                        </div>
                        <div class="tab-pane fade show" id="total-1" role="tabpanel" aria-labelledby="home-tab">
                            <div class="col-12">
                                @include('admin.reports.partials.total')
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        </div>
@endsection
@section('page_js')
<script>
    $('#date-range-my').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    }, function (start, end, label) {
        var startdate = start.format('YYYY-MM-DD');
        var enddate = end.format('YYYY-MM-DD');

        $('#startdate').val(startdate);
        $('#enddate').val(enddate);

    });
    $('.download-report').click(function(e){
        var URL = $(this).attr('href').split("?");
        var reportAll = $("#report-all").serialize();
        $(this).attr('href',URL[0]+'?'+reportAll);
        // e.preventDefault();
        console.log("reportAll:::",reportAll);
        window.location.href = URL[0]+'?'+reportAll;

    })
    $('#date-range-my').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });
</script>
@endsection
