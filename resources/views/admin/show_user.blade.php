@extends('layouts.admin_app')
@section('title', 'View User')
<style>
    .error {
        color: red;
    }
</style>
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div>
                <a class="btn btn-outline-primary" href="{{route('admin.users')}}">Back</a>
            </div>
            <br/>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">User Information</h3>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table text-muted">
                                    <thead>
                                    <tr class="text-black">
                                        <th>Sponser</th>
                                        <th>Identification Number</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Total Capital</th>
                                        <th>Registered</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{isset($sponsor->user_name) ? $sponsor->user_name : ''}}</td>
                                        <td>{{$user->identification_number}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>{{$user->phone_number}}</td>
                                        <td>{{$user->total_capital}}</td>
                                        <td>{{$user->created_at}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
