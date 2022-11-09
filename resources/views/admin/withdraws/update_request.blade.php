@extends('layouts.admin_app')
@section('title', 'Edit Update Request')

@section('content')
<style>
    .error {
        color: red;
    }
</style>
<link rel="stylesheet" href="{{asset('/vendors/summernote/dist/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{asset('/vendors/quill/quill.snow.css')}}">
<link rel="stylesheet" href="{{asset('/vendors/simplemde/simplemde.min.css')}}">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
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
                            <h4 class="card-title">Update Request</h4>
                            <form class="forms-sample" id="updateRequest" method="post"
                                  action="{{route('update-withdraw',['id' => $withdraw->id])}}">
                                @csrf
                                @method('POST')
                                <div class="form-group">
                                    <label for="details_en">Remarks</label>
                                    <textarea type="text" class="form-control" id="remarks" name="remarks"
                                              placeholder="Remarks"></textarea>
                                    <div id="error-remarks"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="status" id="status"
                                                       value="1">
                                                Approve
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="status" id="status"
                                                       value="2">
                                                Reject
                                            </label>
                                        </div>
                                    </div>
                                    <div id="error-display"></div>
                                </div>
                                <br>
                                <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                <a class="btn btn-light" href="{{route('get-withdraw-request')}}">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endsection
            @section('page_js')
                <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
                <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
                <script src="{{asset('/vendors/tinymce/tinymce.min.js')}}"></script>
                <script src="{{asset('/vendors/simplemde/simplemde.min.js')}}"></script>
                <script src="{{asset('/vendors/summernote/dist/summernote-bs4.min.js')}}"></script>
                <script src="{{asset('/vendors/quill/quill.min.js')}}"></script>
                <script src="{{asset('/js/editorDemo.js')}}"></script>
                <script>
                    $('#updateRequest').validate({
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
@endsection
