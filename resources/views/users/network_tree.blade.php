@extends('layouts.app')
@section('title', 'Network Tree')
<style>
    .error {
        color: red;
    }

    div#tabs-holder {
        border: 1px solid #eee;
        padding: 1%;
        border-top: none;
        border-left: none;
        border-right: none;
        width: 100%;
    }

    .accordion .card .card-header a {
        display: initial !important;
    }

    .accordion .card .card-header a[aria-expanded="true"] {
        color: #9eff00 !important;
    }
    @media (max-width: 800px) and (min-width: 768px){
        .d-block .row {
    display: block;
    flex-wrap: wrap;
}
.d-block .row .col-md-4 {
    flex: 0 0 33.33333%;
    max-width: 100.33333%;
    margin-bottom: 10px !important;
}
.d-block .row .col-md-4 #search_username{
    text-align: center;
}
.d-block .row .col-sm-4 {
    flex: 0 0 33.33333%;
    max-width: 100.33333%;
}
    }
</style>
@section('content')
    <div class="d-block mt-30"></div>

    <div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/netwrok-tree.png)">
        <h3 class="m-0 boldbultertext">@lang('network_tree.network_tree')</h3>
    </div>

    <div class="d-block mt-5"></div>

    <header class="section-title titlebottomline">
        <h2 class="hrowheading">@lang('network_tree.network_tree')</h2>
    </header>
    <div class="card">
        <div class="card-body">
            <nav class="nav nav-fill treeiconsrow">
                @if($ranks)
                    @foreach($ranks as $color => $rank)
                        <span class="nav-item rank-{{$color}}">
                             <i class="ti-user"></i><span
                                class="icntxt">{{$rank}}</span></span>
                    @endforeach
                @endif
            </nav>
        </div>
    </div>

    <div class="d-block mt-30"></div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{route('network-tree')}}">
                @csrf
                <div class="d-block csu-d-lg-flex row justify-content-between">
                    <div class="col grid-margin grid-margin-md-0 text-small">
                        @lang('network_tree.note')
                    </div>
                    <div class="row col-md-12 col-cus-lg-7 cus-m-mt-3 ">
                        <div class="col-md-4">
                            <input type="text" name="user_name" placeholder="@lang('general.search_username')"
                                   id="search_username"
                                   class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 search-btn">
                            <button type="submit" name="" id="search_username" class="form-control form-control-sm">
                                @lang('general.search')
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" name="" id="search_username" class="form-control">
                                @lang('general.reset')
                            </button>
                        </div>
                    </div>

                </div>
                <div class="text-center spinner" style="display: none;">
                    <img id="process_img" src="{{asset('images/dashboard/Spinner.gif')}}">
                </div>
            </form>
            <div class="table-responsive py-4">
                <div id="jstreehtml" class="demo">
                    @if(count($networkTress) > 0)
                        @foreach($networkTress as $tree)
                            <div id="accordion-{{$tree->id}}" class="accordion">
                                <div class="card">
                                    <div class="card-header" id="heading-{{$tree->id}}">
                                        <h5 class="mb-0">
                                            <a class="rank-dib collapsed"
                                               data-toggle="collapse" data-id="{{$tree->refferal_id}}"
                                               data-label="{{$tree->id}}" data-target="#collapse-{{$tree->id}}"
                                               aria-expanded="false" aria-controls="collapse-{{$tree->id}}"><i
                                                    class="ti-user"></i><span
                                                    class="icntxt">
                                                        @if(isset($tree->total_group_sale))
                                                            {{ucfirst($tree->refferalName->user_name)}} ({{$tree->total_group_sale}})&nbsp;&nbsp;
                                                        @else
                                                            {{ucfirst($tree->refferalName->user_name)}} (0)&nbsp;&nbsp;
                                                        @endif
                                                    </span>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapse-{{$tree->id}}" class="collapse"
                                         aria-labelledby="heading-{{$tree->id}}" data-parent="#accordion-1"
                                         style="">
                                        <div class="card-body downline-{{$tree->id}} mob-ml-5">
                                            <br/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        No Refferal user found
                    @endif
                </div>
                <div class="modal fade" id="view_breakdown" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"
                     aria-labelledby="myModalLabel" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <a href="javascript:;"
                               class="d-block text-right text-uppercase text-white text-small mr-4 mt-3"
                               data-dismiss="modal" aria-label="Close">@lang('general.close')
                            </a>
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('network_tree.monthly_group_sale')</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                    <tr>
                                        <th>@lang('network_tree.sales')</th>
                                        <th>@lang('network_tree.month')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="breakdown_table">
                                    </tbody>
                                </table>
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
        $(document).ajaxStart(function () {
            $('.spinner').show();
        });
        $(document).ajaxStop(function () {
            $('.spinner').hide();
        });
    </script>
    <script>
        $('body').on('click', ".rank-dib", function (e) {

            var refferal_id = $(this).attr('data-id');
            var treeid = $(this).attr('data-label');
            var aria = $(this).attr('aria-expanded');

            if (aria == 'false') {
                $(this).attr('aria-expanded', 'true');

                aria = $(this).attr('aria-expanded');
            } else {
                $(this).attr('aria-expanded', 'false');
                aria = $(this).attr('aria-expanded');
                $('#collapse-' + treeid).removeClass('show');
                return false;
            }
            if (aria == 'true') {
                $(function () {
                    $.ajax({
                        url: '{{ route('get-downline') }}',
                        data: {
                            downline: refferal_id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data.success == true) {
                                
                                if (data.details.total_sale <= 0) {
                                    data.details.total_sale = 0;
                                }
                                if (data.details.total_group_sale <= 0) {
                                    data.details.total_group_sale = 0;
                                }

                                $(".downline").empty();
                                var str = "";
                                str += `<span class="icntxt d-block ml-lg-5 ml-md-5">@lang("network_tree.total_sale"): ${data.details.total_sale}</span>
                            <span
                        class="icntxt d-block ml-lg-5 ml-md-5">@lang("network_tree.monthly_group_sale"): ${data.details.total_sale}</span>
                            <span
                        class="icntxt ml-lg-5 ml-md-5">@lang("network_tree.total_group_sale"): ${data.details.total_group_sale}</span>
                            <span class="ml-2"><a href="#" data-user_id="${data.details.refferal_id}"class="view_history">View history</a></span>`;

                                if (data.downlines.length > 0) {
                                    str += `<br/><br/>`;
                                    for (var i = data.downlines.length - 1; i >= 0; i--) {
                                        var total_sale = 0;
                                        if (data.downlines[i].total_sale) {
                                            total_sale = data.downlines[i].total_sale;
                                        }
					var strUpper = data.downlines[i].refferal_name.user_name;
					

                                        str += ` <div class="card-header ml-lg-5 ml-md-5" style="padding: 0px;" id="heading-${data.downlines[i].id}">
                                        <h5 class="mb-3">
                                            <a class="rank-dib collapsed" data-id="${data.downlines[i].refferal_name.id}"
                                               data-label="${data.downlines[i].id}"
                                               data-toggle="collapse"  data-target="#collapse-${data.downlines[i].id}"
                                               aria-expanded="false" aria-controls="collapse-${data.downlines[i].id}"><i
                                                    class="ti-user"></i><span
                                                    class="icntxt">${(strUpper.charAt(0).toUpperCase() + strUpper.slice(1))} (${total_sale})&nbsp;&nbsp;</span>
                                            </a>
                                        </h5>


                                    </div>
                                    <div id="collapse-${data.downlines[i].id}" class="collapse"
                                         aria-labelledby="heading-${data.downlines[i].id}" data-parent="#accordion"
                                         style="">
                                        <div class="card-body downline-${data.downlines[i].id} mob-ml-5">
                                            <br/>
                                        </div>
                                    </div>
                                    `;
                                    }
                                }
                                $('#collapse-' + treeid).addClass('show');
                                $('.downline-' + treeid).html(str);
                            }
                        }
                    });
                });
            }
        });

        $('body').on('click', ".view_history", function (e) {
            var user_id = $(this).data('user_id');
            $.ajax({
                url: '{{ route('get-downline-view-history') }}',
                data: {
                    user_id: user_id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        if (response.data.length > 0) {
                            var str = `<tr>`;
                            for (var i = response.data.length - 1; i >= 0; i--) {
                                var date = moment(response.data[i].created_at).format('MMM, Y');

                                str += `<td>${response.data[i].sale}</td>`
                                    + `<td>${date}</td>`
                                    + `</tr>`;
                            }


                        } else {
                            str += `<tr><td>No Data Found </td></tr>`;
                        }
                        $('#breakdown_table').html(str);
                        $('#view_breakdown').modal('show');
                    }
                },
            });
        });
    </script>
@endsection
