<!DOCTYPE html>
<html lang="en">

@include('admin_includes.admin_header')

<body>
@include('admin_includes.admin_navbar')
<!-- container-scroller -->


<div class="container-fluid page-body-wrapper">
    <!-- partial:../../partials/_settings-panel.html -->

    @include('admin_includes.admin_sidebar')

    <div class="main-panel">
        <div class="content-wrapper">
            @if (Session::has('message'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ Session::get('message') }}</li>
                    </ul>
                </div>
            @endif
            <h4 class="font-weight-bold">All Packages</h4>

            <div class="row">
                <div class="col-sm-8 ml-auto" style="float: right;">
                    <a class="btn btn-outline-primary" href="{{route('packages.create')}}">Add</a>
                </div>
            </div>
            <br/>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table text-muted">
                                    <thead>
                                    <!------------------------changes-->
                                    <tr class="text-black">
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @if(isset($packages))
                                            @php $x = $packages->firstItem() @endphp @foreach($packages as $i => $package)
                                                <th>{{$x++}}</th>
                                                <td>{{$package->name}}</td>
                                                <td>{{$package->amount}}</td>
                                                <td>
                                                    <input data-id="{{$package->id}}" type="checkbox"
                                                           data-onstyle="success" data-offstyle="danger"
                                                           data-toggle="toggle" data-on="Active"
                                                           data-off="In-Active" {{ $package->status == 'Active' ? 'checked' : '' }}>
                                                </td>

                                                <td>

                                                    <a class="btn btn-outline-warning"
                                                       href="{{route('packages.edit',['id' => $package->id])}}">Edit</a>

                                                </td>
                                                <td>
                                                    <form method="POST"
                                                          action="{{route('packages.destroy',['id' => $package->id])}}">
                                                        {!! csrf_field() !!}
                                                        {{ method_field('DELETE') }}

                                                        <button type="submit" class="btn btn-outline-danger"
                                                                onclick="return confirm('Are you sure you want to delete this package')">
                                                            Delete
                                                        </button>
                                                    </form>

                                                </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        No Packages available
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- plugins:js -->
        @include('admin_includes.admin_footer')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    </div>
</div>
</body>
</html>
