@extends('layouts.admin_app')
@section('title', 'Create Rank')


@section('content')
<style>
    .form-group label {
        margin-bottom: 0;
    }

    .form-group label {
        padding-top: 0;
        padding-bottom: 0;
    }

    .form-control {
        height: 20px;
        font-size: 13px;
    }

    .row {
        margin-bottom: 5px;
    }

    .error {
        color: red;
    }
</style>
    <div class="main-panel">
        <div class="content-wrapper" style="
    padding-right: inherit;">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    @if(count($errors) > 0 )
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <ul class="p-0 m-0" style="list-style: none;">
                                                @foreach($errors->all() as $error)
                                                    {{$error}}<br/><br/>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <!-- <h3 class="card-title">Add new rank</h3> -->
                                        <form class="form-sample" id="rankForm" method="post"
                                              action="{{route('ranks.store')}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Rank Name</label>
                                                        <!-- first name to rank name-->
                                                        <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                            <input type="text" class="form-control" name="name"
                                                                   placeholder="Enter Rank Name"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Request Direct
                                                            Sale</label>
                                                        <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                            <input type="text" class="form-control" name="direct_sale"
                                                                   placeholder="Enter Request Direct Sale"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Downline Sales</label>
                                                        <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                            <input type="text" class="form-control"
                                                                   name="downline_sales"
                                                                   placeholder="Enter Downline Sale"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Direct Downline</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="direct_downline"
                                                                   placeholder="Enter Direct Downline"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Downline</label>
                                                        <div class="col-sm-12"><!-- col-sm-9 to col-sm-12-->
                                                            <input type="text" class="form-control" name="downline"
                                                                   placeholder="Enter Downline"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Total Downline</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="total_downline"
                                                                   placeholder="Enter Total Downline"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Ownership Bonus</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="ownership_bonus"
                                                                   placeholder="Enter Ownership Bonus"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Unilevel</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="unilevel"
                                                                   placeholder="Enter Unilevel"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Leader Bonus</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="leader_bonus" class="form-control"
                                                                   placeholder="Enter Leader Bonus"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Profit Sharing</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="profit_sharing"
                                                                   class="form-control"
                                                                   placeholder="Enter Profit Sharing"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">Trading Profit</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="trading_profit"
                                                                   class="form-control"
                                                                   placeholder="Enter Trading Profit"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-6 col-form-label">
                                                            <button type="submit" class="btn btn-primary mr-2">Save
                                                            </button>
                                                            <a class="btn btn-light" href="{{route('ranks.index')}}">Back</a>

                                                        </label>

                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endsection
                    @section('page_js')
                        <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
                        <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
                        <script>
                            $(document).ready(function(){
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                            });
                            
                            $('#rankForm').validate({
                                // initialize the plugin
                                rules: {
                                    name: {
                                        required: true,
                                        remote: {
                                            url: '{{route("checkRank")}}',
                                            type: "post",
                                            data: {
                                                name: function () {
                                                    return $("input[name='name']").val();
                                                }
                                            },
                                            dataFilter: function (data) {
                                                var json = JSON.parse(data);
                                                if (json.msg == "true") {
                                                    $("input[name='name']").focus();
                                                    return "\"" + "This rank name already exists" + "\"";
                                                } else {
                                                    return 'true';
                                                }
                                            }
                                        }
                                    },
                                    ownership_bonus: {
                                        required: true,
                                        digits:true,
                                        maxlength: 5
                                    },
                                    direct_sale: {
                                        required: true,
                                        digits:true,
                                        maxlength: 5
                                    },

                                    direct_downline: {
                                        required: true,
                                        digits:true,
                                        maxlength: 5
                                    },

                                    profit_sharing: {
                                        digits:true,
                                        maxlength: 5
                                    },
                                    downline_sales: {
                                        digits:true,
                                        maxlength: 5
                                    },

                                    downline: {
                                        required: true,
                                        digits:true,
                                        maxlength: 5
                                    },

                                    total_downline: {
                                        required: true,
                                        digits:true,
                                        maxlength: 5

                                    },
                                    unilevel: {
                                        required: true,
                                        digits:true,
                                        maxlength: 5
                                    },

                                    leader_bonus: {
                                        required: true,
                                        digits:true,
                                        maxlength: 5
                                    },

                                    trading_profit: {
                                        required: true,
                                        digits:true,
                                        maxlength: 5
                                    },
                                }
                            });
                        </script>

@endsection
