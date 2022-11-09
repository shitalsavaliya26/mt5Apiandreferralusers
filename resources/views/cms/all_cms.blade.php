@extends('layouts.app')
@section('title', 'CMS')
<style>
    .error {
        color: red;
    }

    #image-size img{
        max-width:295px;
    }
</style>
@section('content')
    <div class="d-block mt-30"></div>
    <div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/news-events.png)">
        <h3 class="m-0 boldbultertext">CMS</h3>
    </div>
    <div class="d-block mt-5"></div>
    <div class="card">
        <div class="card-body">
            <div class="d-block csu-d-lg-flex row justify-content-between">
                <div class="grid-margin grid-margin-md-0 col">
                    <div class="">
                        <form method="post" action="{{route('cms.all')}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12 col-md-6 cus-m-mt-3">
                                    <select class="text-white form-control" name="year">
                                        @for ($year=2020; $year <= 2050; $year++)
                                            <option value="{{$year}}" {{$year == $selectedYear ? 'selected' : ''}}>{{$year}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 col-md-6 cus-m-mt-3">
                                    <select class="text-white form-control " name="month">
                                        @php
                                        $months = ['1' => 'January','2' => 'February','3' =>'March', '4' =>'April', '5' => 'May', '6' => 'June', '7' => 'July','8' =>  'August', '9' =>'September', '10' => 'October', '11' => 'November', '12' => 'December'];
                                        @endphp
                                        @foreach($months as $key => $m)
                                            <option value="{{$key}}"  {{$key == $month ? 'selected' : ''}}>{{$m}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-2 col-sm-12 cus-m-mt-3">
                                        <select class="text-white form-control btn-reset" name="language" >                                     
                                                <option value="en"  {{$language == 'en' ? 'selected' : ''}}>
                                                    <a class="dropdown-item" href="#"><i
                                                    class="flag-icon flag-icon-us" title="us" id="us"></i> &nbsp;English</a>
                                                </option>
                                                <option value="es"  {{$language == 'es' ? 'selected' : ''}}>
                                                    <a class="dropdown-item" href="#">
                                                <i class="flag-icon flag-icon-ad" title="ad" id="ad"></i> &nbsp;Spanish</a>
                                                </option>

                                        </select>
                                </div>
              
                                <div class="col-lg-2 col-sm-12 cus-m-mt-3">
                                    <button type="submit" name="" id="search_username" class="form-control btn-reset">
                                        @lang('general.search')
                                    </button>
                                </div>
                                <div class="col-lg-2 col-sm-12 text-center cus-m-mt-3">
                                    <a href="{{route('cms.all')}}" id="" class="form-control btn-reset" style=" text-decoration: none;"onmouseover = "$(this).css('color','white');">
                                        @lang('general.reset')
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="">
                    <div class="col grid-margin grid-margin-md-0">
                        <form>
                            <div class="d-flex flex-wrap align-items-center">
                                <div>@lang('general.show')</div>
                                <select id="pagination" class="form-control form-control-sm showperpage">
                                    <option value="5" @if($items == 5) selected @endif >5</option>
                                    <option value="10" @if($items == 10) selected @endif >10</option>
                                    <option value="25" @if($items == 25) selected @endif >25</option>
                                    <option value="50" @if($items == 50) selected @endif >50</option>
                                    <option value="100" @if($items == 100) selected @endif >100</option>
                                </select>
                                <div>@lang('general.entries')</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-block mt-30"></div>
    <div class="row">
        @if($cms)
            @foreach($cms as $n)
                <div class="col-sm-6 col-md-6 col-lg-4 mb-30px">
                    <div class="card">
                        <a href="#" data-image="{{$n->image}}" data-title="{{$n->title}}" data-details="{{$n->details}}"
                           class="color-inherit text-decoration-none view_news">
                            <span
                                class="btn-my-gradient py-2 px-3 position-absolute boldbultertext">{{$n->created_at->format('jS M Y')}}</span>
                            <img class="card-img-top" src="{{asset('/cms_images')}}/{{$n->image}}" style="height:150px;
                                 max-width:450px" alt="">
                            <div class="card-body card-cus-details" id="image-size">
                                <h4 class="card-title mt-3 boldbultertext">{{$n->title}}</h4>
                                <div class="card-text"><?php echo $n->details ?></div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            @lang('general.no_record')
        @endif
    </div>
    <div class="modal fade" id="view_news" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"
         aria-labelledby="myModalLabel" role="dialog" aria-hidden="true">
        <div class="modal-dialog lg" role="document">
            <div class="modal-content p-4">
                <a href="javascript:;" class="d-block text-right text-uppercase text-white text-small"
                   data-dismiss="modal" aria-label="Close">@lang('general.close')</a>
                <div class="modal-content p-4">
                    <img src="" class="imagepreview" style="height:180px;
                                 max-width:450px">
                </div>
                <div class="mb-3 mt-3">
                    <h4 class="medbultertext text-white m-0" id="news-name"></h4>
                </div>
                <p class="mb-3 regbultertext text-white desk-f-x-small"  id="details"></p>
            </div>
        </div>
    </div>
    <div class="cardbg">
        <div class="d-block d-md-flex row justify-content-between align-items-center">
            
            @if($cms->total() > 0)
                <div class="col grid-margin grid-margin-md-0">@lang('general.showing') {{ $cms->firstItem() }}
                    to {{ $cms->lastItem() }}
                    of {{ $cms->total() }} @lang('general.entries')
                </div>
            @else
                <div class="col-12 d-block text-center">
                    No records found
                </div>
            @endif
            <div class="col">
                <ul class="pagination flex-wrap justify-content-md-end mb-0">
                    {{$cms->links()}}
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script>
        document.getElementById('pagination').onchange = function () {
            window.location = "{{ $cms->url(1) }}&items=" + this.value;
        };

        $('.view_news').on('click', function () {
            var title = $(this).data('title');
            var details = $(this).data('details');

            var newsrc = "{{asset('/cms_images')}}"
            var image = $(this).data('image');
            $('.imagepreview').attr('src', newsrc + "/".concat(image));

            $('#news-name').text(title);
            $('#details').html(details);
            $('#view_news').modal('show');
        });
    </script>
@endsection

