@extends('layouts.admin_app')
@section('title', 'Admin | Ownership Profit')
@section('content')
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
        <h4 class="font-weight-bold">Ownership Profit</h4>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="p-b-sm">Upload Trading HTML</h4>
                        {!! Form::open(['route' => ['admin.ownership.import'],'class'=>'','method'=>'post','id'=>'pips_rebate','files'=>'true']) !!}
                            <div class="form-group">
                                <label>Select Html</label>
                                {!! Form::file('importFile',['class'=>'form-control m-input','placeholder'=>'Please select file','required','accept'=>'text/html']) !!}
                                <span class="help-block">{{$errors->first('importFile')}}</span>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Upload and Parse</button>
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 display-tbl">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="order-listing" class="table text-muted">
                                <thead>
                                <!------------------------changes-->
                                <tr class="text-black">
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Filename</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @if(isset($ownershipHistory))
					@php $x = $ownershipHistory->firstItem() @endphp
                                        @foreach($ownershipHistory as $i => $history)
                                        <tr>
                                            <th>{{$x++}}</th>
                                            <td>{{$history->created_at->format('m/d/Y')}}</td>
                                            <td>{{$history->file_name}}</td>
                                        </tr>
                                        @endforeach
                                @else
                                    No Data available
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
                            @if($ownershipHistory->total() > 0)
                                <div class="col grid-margin grid-margin-md-0">Showing {{ $ownershipHistory->firstItem() }}
                                    to {{ $ownershipHistory->lastItem() }} of {{ $ownershipHistory->total() }} entries
                                </div>
                            @else
                                <div style="padding-left: 450px;">
                                    No records found
                                </div>
                            @endif
                            <div class="col">
                                <ul class="pagination flex-wrap justify-content-md-end mb-0">
                                    {{$ownershipHistory->links()}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
@endsection

