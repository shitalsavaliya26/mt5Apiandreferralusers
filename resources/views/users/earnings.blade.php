@extends('layouts.app')
@section('title', 'Withdraw')
<style>
    .error{
        color: red;
    }
</style>
@section('content')

<div class="d-block mt-30"></div>

<div class="text-white text-center w-100 medimagebgdiv" style="background-image: url(./images/earnings.png)">
    <h3 class="m-0 boldbultertext">Earnings</h3>
</div>

<div class="d-block mt-5"></div>

<div class="row">
    <div class="col-12 col-xl-4">
        <div class="stretch-card">
            <div class="card cardhoverable active">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="fa fa-money icon-5rem"></i>
                        </div>
                        <div class="col">
                            <p class="card-title mb-2">Account Balance</p>
                            <h3 class="mb-0 text-uppercase">$9,000,000</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-5 mt-4 mt-xl-0">
        <form class="forms-sample">
            <h3 class="medbultertext text-white mb-4">Withdrawal</h3>
            <div class="bluebox p-3 mb-4">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col"><span class="medbultertext text-white">Account No:</span></div>
                            <div class="col"><span class="regbultertext text-muted">9899900</span></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col"><span class="medbultertext text-white">Account Name:</span></div>
                            <div class="col"><span class="regbultertext text-muted">Avanya Trading</span></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col"><span class="medbultertext text-white">Bank Name:</span></div>
                            <div class="col"><span class="regbultertext text-muted">alpha bank</span></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col"><span class="medbultertext text-white">Bank location:</span></div>
                            <div class="col"><span class="regbultertext text-muted">Shenzhen</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row ">
                <label for="exampleInput1" class="col-sm-4 medbultertext text-white mb-0 align-self-center">Withdrawal Amount:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="exampleInput1" placeholder="">
                </div>
            </div>
            <div class="form-group row ">
                <label for="exampleInput3" class="col-sm-4 medbultertext text-white mb-0 align-self-center">Security Password:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control form-control-sm" id="exampleInput3" placeholder="">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <button type="submit" class="w-100 btn btn-primary text-uppercase">Submit</button>
                </div>
            </div>

        </form>
    </div>
    <div class="col-12 col-xl-3 mt-5 mt-xl-0">
        <h4 class="medbultertext text-white mb-4">Terms & Condition</h4>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit</p>
        <p class="mt-4">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam</p>
    </div>
</div>

<div class="hrlinelight mt-4 mb-5"></div>

<header class="section-title titlebottomline">
    <h2 class="hrowheading">Withdrawal History</h2>
</header>
<div class="card">
    <div class="card-body">
        <div class="d-block d-md-flex row justify-content-between mb-3">
            <div class="col grid-margin grid-margin-md-0">
                <div class="d-flex flex-wrap align-items-center">
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
            <div class="col daterangeintable">
                <div id="" class="input-group">
                    <input type="text" name="date-range" class="form-control">
                    <span class="input-group-addon input-group-append border-left">
            <span class="ti-calendar input-group-text"></span>
          </span>
                </div>
            </div>
        </div>

        <div class="d-block mt-30 d-md-none"><i class="fa fa-hand-o-right"></i> Scroll right to see data in table.</div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th><i class="fa fa-arrow-up active"></i> <i class="fa fa-arrow-down mr-2"></i> No.</th>
                    <th><i class="fa fa-arrow-up active"></i> <i class="fa fa-arrow-down mr-2"></i> Payout</th>
                    <th><i class="fa fa-arrow-up active"></i> <i class="fa fa-arrow-down mr-2"></i> Date</th>
                    <th><i class="fa fa-arrow-up active"></i> <i class="fa fa-arrow-down mr-2"></i> Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>$999,999,999</td>
                    <td>1/1/2019</td>
                    <td><label class="badge badge-danger">Pending</label></td>
                    <td><a href="javascript:;" class="badge badge-outline-primary px-3">View</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>$999,999,999</td>
                    <td>1/1/2019</td>
                    <td><label class="badge badge-warning">Pending</label></td>
                    <td><a href="javascript:;" class="badge badge-outline-primary px-3">View</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>$999,999,999</td>
                    <td>1/1/2019</td>
                    <td><label class="badge badge-info">Pending</label></td>
                    <td><a href="javascript:;" class="badge badge-outline-primary px-3">View</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>$999,999,999</td>
                    <td>1/1/2019</td>
                    <td><label class="badge badge-success">Pending</label></td>
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
@endsection
