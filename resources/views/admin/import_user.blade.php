
@extends('layouts.admin_app')
@section('title', 'Import Users')

@section('page_css')
<link rel="stylesheet" type="text/css" href="{{asset('css/magnific-popup.css')}}" />
@endsection
@section('content')
<style>
    .error {
        color: red;
    }
</style>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="mt-2">
                <a class="btn btn-outline-primary" href="{{route('admin.users')}}">Back</a>
                <div class="float-right">
                <a class="btn btn-outline-warning  magic-popup" href="{{asset('userProfile/sample_import_user.png?'.time())}}" >View Sample File</a> &nbsp;&nbsp;
                <a class="btn btn-outline-warning" href="{{asset('userProfile/sample_import_user.xlsx')}}" download>Download Sample File</a> &nbsp;&nbsp;
                </div>
            </div>
            <br/>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Import User</h3>
                
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
                @if(session()->has('user_exist'))
                    <div class="alert alert-danger">
                        {{ session()->get('user_exist') }}
                    </div>
                @endif
                @if(session()->has('custom_error'))
                    <div class="alert alert-danger">
                        {{ session()->get('custom_error') }}
                    </div>
                @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('users-imports') }}" method="POST" id="import" enctype="multipart/form-data">
                        @csrf
                        <input type="file" required name="file" class="form-control">
                        <br>
                        <label style="font-size:12px;font-family: monospace"> Only .xlsx file type allow to import</label>
                        <br/>
                        <button type="submit" class="btn btn-success">Import User Data</button>
                    </form>

                </div>
            </div>

            <br/>

            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Import History</h3>
                </div>
                <div class="card-body">
                    <table style="border: 1px solid silver
                        ;" cellpadding="15" cellspacing="40" width="600">
                        <th style="border-bottom:1px solid silver;border-right:1px solid silver;">
                            File Name
                        </th>
                        <th style="border-bottom:1px solid silver">
                            Import Date
                        </th>

                        @if($importHistory)
                            <tr>
                                @foreach($importHistory as $history)
                                    <td style="border:1px solid silver;">
                                        {{$history->file_name}}
                                    </td>
                                    <td style="border:1px solid silver;">
                                        {{$history->created_at}}
                                    </td>

                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td> No History available</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="mx-auto">
                    {{$importHistory->links()}}
                </div>
            </div>

        </div>
        @endsection
        @section('page_js')
            <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
            <script>
                $('#import').validate({
                    // initialize the plugin
                    rules: {
                        file: {
                            required: true,
                            extension: "xls|csv|xlsx"
                        },
                    }
                });
            </script>
        <script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
        <script type="text/javascript">
            $('a.magic-popup').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: {
                    verticalFit: true
                }
                
            });
        </script>
@endsection
