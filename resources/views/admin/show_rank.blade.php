@extends('layouts.admin_app')
@section('title', 'Show Rank')
<style>
    .error {
        color: red;
    }
    td{
        padding: 10px 0px 0px 50px !important;
    }
</style>
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div>
                <a class="btn btn-outline-primary" href="{{route('ranks.index')}}">Back</a>
            </div>
            <br/>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Rank Information</h3>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" >
                                    <tr>
                                        <td><strong>Name</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->name}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Direct Sale</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->direct_sale}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Downline Sales</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->downline_sales}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Direct Downline</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->direct_downline}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Downline</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->downline}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Downline</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->total_downline}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ownership Bonus</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->ownership_bonus}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Unilevel</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->unilevel}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Leader Bonus</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->leader_bonus}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Profit Sharing</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->profit_sharing}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Trading Profit</strong></td>
                                        <td>:</td>
                                        <td>{{$rank->trading_profit}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
