@extends('layouts.admin_app')
@section('title', 'ShareHolder Earning')

@section('content')
<style>
    .error {
        color: red;
    }
</style>
    <div class="main-panel">
        <div class="content-wrapper">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session()->get('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <h4 class="font-weight-bold">ShareHolder Earning</h4>
            <br/>
            <div class="row ml-auto">
                <div class="col-md-12">
                    {!! Form::open(['route' => 'share-holder.earning','method'=>'get','id'=>'filter_data_ajax']) !!}
                        <div class="ml-2">
                            <div id="" class="input-group">
                                <div class="row col-lg-9 col-md-12 ml-auto search-field p-0">
                                    <div class="col-md-4 search-inpt">
                                        <input type="text" name="user_name"
                                               placeholder="@lang('general.search_username')"
                                               id="search_username" class="form-control" value="{{@$data['user_name']}}" autocomplete="off">
                                    </div>
                                    <div class="col-md-4 search-inpt">
                                        <input type="text" name="range" placeholder="Select Date"
                                               value="{{@$data['range']}}" class="form-control">
                                        <input type="hidden" name="start_date"  value="{{@$data['start_date']}}" id="startdate" class="form-control">
                                        <input type="hidden" name="end_date" id="enddate" value="{{@$data['end_date']}}"  class="form-control">
                                        <span class="input-group-addon input-group-append border-left"></span>
                                    </div>
                                    <div class="row col-md-4 search-action">
                                        <button type="submit" name="submit"
                                                class=" btn-outline-twitter input-group-text">
                                            Search
                                        </button>&nbsp;
                                        <a href="{{route('share-holder.earning')}}" class="btn-outline-twitter input-group-text" style="color:#2caae1;text-decoration:none;" onMouseOver="this.style.color='#ffffff'" onMouseOut="this.style.color='#2caae1'">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div id="response_message"></div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table text-muted">
                                    <thead>
                                    <!------------------------changes-->
                                    <tr class="text-black">
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Percent</th>
                                        <th>Amount</th>
                                        <th>Residual Amount</th>
                                        {{-- <th>TotalAmount (10% of Trading Profit)</th> --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                        @if(isset($shareHolders))
					                       @php $x = $shareHolders->firstItem() @endphp
                                            @foreach($shareHolders as $i => $row)
                                            @php 
                                                $profitAmt = ($profit*0.1) + $residual_income; 
                                                $percent = $profitAmt!=null && $profitAmt > 0 ? ($profitAmt*$row->percent / 100) : 0;
                                            @endphp
                                                <th>{{$x++}}</th>
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->percent}}%</td>
                                                <td align="left">IDR {{number_format($percent,2)}}</td>
                                                <td align="left">IDR {{number_format($residual_income,2)}}</td>
                                                {{-- <td align="left">IDR {{number_format($profitAmt,2)}}</td> --}}
                                                
                                    </tr>
                                    @endforeach
                                    @else
                                        No Users available
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                                
                                @if($shareHolders->total() > 0)
                                    <div class="col grid-margin grid-margin-md-0">Showing {{ $shareHolders->firstItem() }}
                                        to {{ $shareHolders->lastItem() }} of {{ $shareHolders->total() }} entries
                                    </div>
                                @else
                                    <div style="padding-left: 450px;">
                                        No records found
                                    </div>
                                @endif
                                <div class="col">
                                    <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                        {{$shareHolders->links()}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
    <!-- plugins:js -->
        @section('page_js')
            
            <script>
                $('input[name="range"]').daterangepicker({
                    opens: 'left',
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    },
                    maxDate:new Date(),
                }, function (start, end, label) {
                    var startdate = start.format('YYYY-MM-DD h:mm:ss');
                    var enddate = end.format('YYYY-MM-DD h:mm:ss');

                    $('#startdate').val(startdate);
                    $('#enddate').val(enddate);

                });

                $('input[name="range"]').on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                });
            </script>
@endsection
