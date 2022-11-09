<!DOCTYPE html>
<html lang="en">

@include('admin_includes.admin_header')

<body>
<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    @include('admin_includes.admin_navbar')

    <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_settings-panel.html -->

        @include('admin_includes.admin_sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">

                        <div class="card">

                            <div class="card-body">
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
                                <h1 class="card-title">Edit Package </h1>
                                <form class="forms-sample" method="post"
                                      action="{{ route('packages.update',['id' => $package->id])}}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Package Name</label>
                                        <input type="text" class="form-control" id="exampleInputUsername1" name="name"
                                               value="{{old('name',$package->name)}}" placeholder="enter package name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Amount</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               value="{{old('amount',$package->amount  )}}" name="amount"
                                               placeholder="enter package amount">
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="status"
                                                           id="membershipRadios1"
                                                           value="active" {{(old('status',$package->status) == 'active') ? 'checked' : ''}}>
                                                    Active
                                                    <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="status"
                                                           id="membershipRadios2"
                                                           value="in-active" {{(old('status',$package->status) == 'in-active') ? 'checked' : ''}}>
                                                    In-Active
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light" type="reset">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a
                            href="#" target="_blank">Avanya</a>. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &amp; made with <i
                            class="ti-heart text-danger ml-1"></i></span>
                </div>
            </footer>
            <!-- partial -->
        </div>
    </div>
</div>
@include('admin_includes.admin_footer')
</body>

</html>
