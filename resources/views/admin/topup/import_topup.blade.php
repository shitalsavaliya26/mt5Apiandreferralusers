@extends('layouts.admin_app')
@section('title', 'Import Topup')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div>
                <a class="btn btn-outline-primary" href="{{route('get-topup-request')}}">Back</a>
            </div>
            <br/>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Import Topup Request</h3>
                </div>
                @if(count($errors) > 0 )
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="p-0 m-0" style="list-style: none;">
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if(session()->has('custom_error'))
                    <div class="alert alert-danger">
                        {{ session()->get('custom_error') }}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('topup-imports') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" required name="file" class="form-control">
                        <br>
                        <label style="font-size:12px;font-family: monospace"> Only .xls,.xlsx,.csv file type
                            allowed</label>
                        <br/>
                        <button class="btn btn-success">Import Topup Request</button>
                    </form>
                </div>
            </div>
        </div>
@endsection
