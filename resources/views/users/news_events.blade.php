@include('includes.header')
<div class="d-block mt-30"></div>

<div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/news-events.png)">
    <h3 class="m-0 boldbultertext">@lang('models/news.singular')</h3>
</div>

<div class="d-block mt-5"></div>

<div class="card">
    <div class="card-body">
        <div class="d-block d-md-flex row justify-content-between">
            <div class="col grid-margin grid-margin-md-0">
                <div class="d-flex flex-wrap align-items-center">
                    <select class="text-white width-auto form-control form-control-sm mr-3">
                        <option>2019</option>
                        <option>2018</option>
                        <option>2017</option>
                        <option>2016</option>
                        <option>2015</option>
                    </select>
                    <select class="text-white width-auto form-control form-control-sm">
                        <option>September</option>
                        <option>September</option>
                        <option>September</option>
                        <option>September</option>
                        <option>September</option>
                    </select>
                </div>
            </div>
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @php $locale = session()->get('locale'); @endphp
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @switch($locale)
                            @case('es')
                            Spanish
                            @break
                            @default
                            English
                        @endswitch
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('lang',['locale' => 'en'])}}"><i
                                class="flag-icon flag-icon-us" title="us" id="us"></i> &nbsp;English</a>
                        <a class="dropdown-item" href="{{route('lang',['locale' => 'es'])}}">
                            <i class="flag-icon flag-icon-ad" title="ad" id="ad"></i> &nbsp;Spanish</a>
                    </div>
                </li>
            </ul>

            <div class="col">
                <div class="d-flex flex-wrap align-items-center justify-content-end">
                    <div>Show</div>
                    <select class="form-control form-control-sm showperpage">
                        <option>10</option>
                        <option>20</option>
                        <option>30</option>
                        <option>40</option>
                        <option>50</option>
                        <option>100</option>
                        <option>200</option>
                        <option>500</option>
                        <option>1000</option>
                        <option>2000</option>
                        <option>All</option>
                    </select>
                    <div>entries</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-block mt-30"></div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-4 mb-30px">
        <div class="card">
            <a href="javascript:;" class="color-inherit text-decoration-none">
                <span class="btn-my-gradient py-2 px-3 position-absolute boldbultertext">1st Jan 2019</span>
                <img class="card-img-top" src="./images/dashboard/news-1.jpg" alt="">
                <div class="card-body">
                    <h4 class="card-title mt-3 boldbultertext">Card title that wraps to a new line</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad blanditiis quam, sequi dolorum excepturi repudiandae atque dignissimos voluptatum aperiam!</p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 mb-30px">
        <div class="card">
            <a href="javascript:;" class="color-inherit text-decoration-none">
                <span class="btn-my-gradient py-2 px-3 position-absolute boldbultertext">1st Jan 2019</span>
                <img class="card-img-top" src="./images/dashboard/news-1.jpg" alt="">
                <div class="card-body">
                    <h4 class="card-title mt-3 boldbultertext">Card title that wraps to a new line</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad blanditiis quam, sequi dolorum excepturi repudiandae atque dignissimos voluptatum aperiam!</p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 mb-30px">
        <div class="card">
            <a href="javascript:;" class="color-inherit text-decoration-none">
                <span class="btn-my-gradient py-2 px-3 position-absolute boldbultertext">1st Jan 2019</span>
                <img class="card-img-top" src="./images/dashboard/news-1.jpg" alt="">
                <div class="card-body">
                    <h4 class="card-title mt-3 boldbultertext">Card title that wraps to a new line</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad blanditiis quam, sequi dolorum excepturi repudiandae atque dignissimos voluptatum aperiam!</p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 mb-30px">
        <div class="card">
            <a href="javascript:;" class="color-inherit text-decoration-none">
                <span class="btn-my-gradient py-2 px-3 position-absolute boldbultertext">1st Jan 2019</span>
                <img class="card-img-top" src="./images/dashboard/news-1.jpg" alt="">
                <div class="card-body">
                    <h4 class="card-title mt-3 boldbultertext">Card title that wraps to a new line</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad blanditiis quam, sequi dolorum excepturi repudiandae atque dignissimos voluptatum aperiam!</p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 mb-30px">
        <div class="card">
            <a href="javascript:;" class="color-inherit text-decoration-none">
                <span class="btn-my-gradient py-2 px-3 position-absolute boldbultertext">1st Jan 2019</span>
                <img class="card-img-top" src="./images/dashboard/news-1.jpg" alt="">
                <div class="card-body">
                    <h4 class="card-title mt-3 boldbultertext">Card title that wraps to a new line</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad blanditiis quam, sequi dolorum excepturi repudiandae atque dignissimos voluptatum aperiam!</p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 mb-30px">
        <div class="card">
            <a href="javascript:;" class="color-inherit text-decoration-none">
                <span class="btn-my-gradient py-2 px-3 position-absolute boldbultertext">1st Jan 2019</span>
                <img class="card-img-top" src="./images/dashboard/news-1.jpg" alt="">
                <div class="card-body">
                    <h4 class="card-title mt-3 boldbultertext">Card title that wraps to a new line</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad blanditiis quam, sequi dolorum excepturi repudiandae atque dignissimos voluptatum aperiam!</p>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="cardbg">
    <div class="d-block d-md-flex row justify-content-between align-items-center">
        <div class="col grid-margin grid-margin-md-0">Showing 1 to 10 of 10 entries</div>
        <div class="col">
            <ul class="pagination flex-wrap justify-content-md-end mb-0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </div>
    </div>
</div>

@include('includes.footer')
