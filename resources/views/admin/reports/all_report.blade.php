@extends('layouts.admin_app')
@section('title', 'All Report')
@section('content')
    <div class="">
        <div class="content-wrapper">
            <h4 class="font-weight-bold">Export All Reports</h4>
            <div class="row mt-5">
                <div class="col-sm-12 mr-2">
                    <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2" href="{{route('trading-profit-exports')}}">Trading Profit</a>
                    <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2" href="{{route('unilevel-exports')}}">Unilevel</a>
                    <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2" href="{{route('profit-sharing-exports')}}">Profit Sharing</a>
                    <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2" href="{{route('leadership-exports')}}">Leadership Bonus</a>
                    <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2" href="{{route('ownership-exports')}}">Ownership Bonus</a>
                    <a class="col-sm-12 col-lg-2 col-md-4 btn text-black btn-outline-dark mr-4 mt-2" href="{{route('total-exports')}}">Total</a>
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

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>
    </div>
    </div>
@endsection
@section('page_js')
    <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
    <script>
        $('#update-withdraw').validate({
            // initialize the plugin
            rules: {
                remarks: {
                    required: true
                },
                status: {
                    required: true
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "status") {
                    error.appendTo($('#error-display'));
                } else if (element.attr("name") == "remarks") {
                    error.appendTo($('#error-remarks'));
                }
            }
        });
    </script>
    <script type="text/javascript">
        jQuery.noConflict();
        $('.update-withdraw').on('click', function () {
            var id = $(this).data('id');
            var user_id = $(this).data('user_id');
            var amount = $(this).data('amount');
            var newsrc = "{{url('avanya-vip-portal/update-withdraw-status')}}";

            $('input#user_id').val(user_id);
            $('input#amount').val(amount);
            $('#update-withdraw').attr('action', newsrc + "/".concat(id));
            $('#updateWithdraw').modal('show');
        });

        jQuery(document).ready(function () {
            jQuery('#master').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });

            $('.update_all').on('click', function (e) {

                var allVals = [];
                jQuery(".sub_chk:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                if (allVals.length <= 0) {
                    alert("Please select request.");
                } else {
                    var status = $('#status').val();
                    var join_selected_values = allVals.join(",");

                    $.ajax({
                        url: '{{route('bulk-withdraw-request-update')}}',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'ids': join_selected_values, 'status': status},
                        success: function (data) {
                            if (data.status == true) {
                                alert('bulk status updated successfully')
                            }
                            window.location.reload();
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });

                }
            });
        });
    </script>
    <script>

        $('input[name="date-range-my"]').daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        }, function (start, end, label) {
            var startdate = start.format('YYYY-MM-DD h:mm:ss');
            var enddate = end.format('YYYY-MM-DD h:mm:ss');

            $('#startdate').val(startdate);
            $('#enddate').val(enddate);

        });

        $('input[name="date-range-my"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });
    </script>
    <script>
        $(window).on('hashchange', function () {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getData(page);
                }
            }
        });

        $(document).ready(function () {
            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];

                getData(page);
            });

        });

        function getData(page) {
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html"
                }).done(function (data) {
                $("#tag_container").empty().html(data);
                location.hash = page;
            }).fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }
    </script>
@endsection
