@include('includes.header')
<div class="d-block mt-30"></div>

<div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/support.png)">
    <h3 class="m-0 boldbultertext">Support Page</h3>
</div>

<div class="d-block mt-5"></div>

<div class="row">
    <div class="col-12 col-xl-3">
        <div class="card p-3">
            <a href="javascript:;" class="d-block btn btn-primary text-uppercase">Create ticket</a>
            <div class="pt-4">
                <div class="row mb-3">
                    <div class="col medbultertext text-white">All Tickets</div>
                    <div class="col text-right"><span class="counter">0</span></div>
                </div>
                <div class="hrlinedark mb-3"></div>
                <div class="row mb-3">
                    <div class="col medbultertext text-white">Opened</div>
                    <div class="col text-right"><span class="counter">0</span></div>
                </div>
                <div class="hrlinedark mb-3"></div>
                <div class="row">
                    <div class="col medbultertext text-white">Closed</div>
                    <div class="col text-right"><span class="counter">0</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-9 mt-4 mt-xl-0 recent-ticket">
        <header class="section-title titlebottomline mt-4">
            <h2 class="hrowheading">Recent Tickets</h2>
        </header>
        <div class="card">
            <div class="card-body">
                <div class="d-block d-md-flex row justify-content-between mb-3">
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
                    <div class="row mr-auto">
                        <div id="" class="input-group col-sm-8">
                            <input type="text" name="date-range" class="form-control">
                            <span class="input-group-addon input-group-append border-left">
                                 <span class="ti-calendar input-group-text"></span>
                            </span>
                        </div>
                    </div>
                    <div class="input-group col-sm-4">
                        <button type="submit" name="submit"
                                class="btn-outline-twitter input-group-text btn-reset">@lang('general.reset')
                        </button>
                    </div>
                </div>

                <div class="d-block mt-30 d-md-none"><i class="fa fa-hand-o-right"></i> Scroll right to see data in
                    table.
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th><i class="fa fa-arrow-up active"></i> <i class="fa fa-arrow-down mr-2"></i> No.</th>
                            <th><i class="fa fa-arrow-up active"></i> <i class="fa fa-arrow-down mr-2"></i> Subject</th>
                            <th><i class="fa fa-arrow-up active"></i> <i class="fa fa-arrow-down mr-2"></i> Posted</th>
                            <th><i class="fa fa-arrow-up active"></i> <i class="fa fa-arrow-down mr-2"></i> Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>General Inquiry</td>
                            <td>1/1/2019 10:12:45</td>
                            <td><label class="badge badge-success">Open</label></td>
                            <td><a href="javascript:;" class="badge badge-outline-primary px-3">View</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>General Inquiry</td>
                            <td>1/1/2019 10:12:45</td>
                            <td><label class="badge badge-danger">Pending</label></td>
                            <td><a href="javascript:;" class="badge badge-outline-primary px-3">View</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>General Inquiry</td>
                            <td>1/1/2019 10:12:45</td>
                            <td><label class="badge badge-success">Open</label></td>
                            <td><a href="javascript:;" class="badge badge-outline-primary px-3">View</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>General Inquiry</td>
                            <td>1/1/2019 10:12:45</td>
                            <td><label class="badge badge-danger">Pending</label></td>
                            <td><a href="javascript:;" class="badge badge-outline-primary px-3">View</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>General Inquiry</td>
                            <td>1/1/2019 10:12:45</td>
                            <td><label class="badge badge-success">Open</label></td>
                            <td><a href="javascript:;" class="badge badge-outline-primary px-3">View</a></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>General Inquiry</td>
                            <td>1/1/2019 10:12:45</td>
                            <td><label class="badge badge-danger">Pending</label></td>
                            <td><a href="javascript:;" class="badge badge-outline-primary px-3">View</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-block d-md-flex row justify-content-between mt-4 align-items-center">
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
        </div>
    </div>
</div>

@include('includes.footer')