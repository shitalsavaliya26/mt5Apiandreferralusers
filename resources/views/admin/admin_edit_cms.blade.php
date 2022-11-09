@extends('layouts.admin_app')
@section('title', 'Edit CMS')

@section('content')<link rel="stylesheet" href="{{asset('/vendors/summernote/dist/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{asset('/vendors/quill/quill.snow.css')}}">
<link rel="stylesheet" href="{{asset('/vendors/simplemde/simplemde.min.css')}}">
<style>
    .error {
        color: red;
    }
    .editor-toolbar a:before {
        color: aliceblue;
    }
</style>

    <div class="main-panel">
        <div class="content-wrapper" style="padding: inherit">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
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
                            <h4 class="card-title">Edit CMS</h4>
                            <form class="forms-sample" id="editCMS" method="post"
                                  action="{{ route('cms.update',['id' => $cms->id])}}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title </label>
                                        <input type="text" class="form-control" id="title"
                                               value="{{old('title',$cms->title)}}" name="title" placeholder="Title">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="language">Language</label>
                                        <select class="form-control" name="language" id="language">
                                            <option value="">Select language</option>
                                            <option value="en" {{$cms->language == 'en' ? 'selected': ''}}>English
                                            </option>
                                            <option value="es" {{$cms->language == 'es' ? 'selected': ''}}>Spanish
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="details_en">Details</label>
                                        <textarea type="text" class="form-control" id="details_en" name="details"
                                                  placeholder="Details">{{$cms->details}}</textarea>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>File upload</label>
                                        <input type="file" name="image" class="file-upload-default">
                                        <div class="input-group col-xs-6">
                                            <input type="text" class="form-control file-upload-info" disabled
                                                   placeholder="Upload Image">
                                            <span class="input-group-append">
                              <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                                        </div>
                                        <span class="input-group-append">

                                        @if(!empty($cms->image))
                                                <img src="{{url('uploads/cms_images/'.$cms->image)}}" height="50" width="50">
                                            @else
                                                No Image
                                            @endif
                                    </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="form-label mt-2">Status</label></div>
                                            <div class="col-sm-3">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="status"
                                                               id="active"
                                                               value="0" {{(old('status',$cms->status) == '0') ? 'checked' : ''}}>
                                                        Active
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="status"
                                                               id="inactive"
                                                               value="1" {{(old('status',$cms->status) == '1') ? 'checked' : ''}}>
                                                        Inactive
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                <a class="btn btn-light" href="{{route('cms.index')}}">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endsection
            @section('page_js')
                <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
                <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
                <script>
                    $('#editCMS').validate({
                        // initialize the plugin
                        rules: {
                            title: {
                                required: true,
                                maxlength: 25
                            },
                            details: {
                                required: true
                            },
                            language: {
                                required: true
                            },
                        }
                    });
                </script>
                <script src="{{asset('/vendors/tinymce/tinymce.min.js')}}"></script>
                <script src="{{asset('/vendors/simplemde/simplemde.min.js')}}"></script>
                <script src="{{asset('/vendors/summernote/dist/summernote-bs4.min.js')}}"></script>
                <script src="{{asset('/vendors/quill/quill.min.js')}}"></script>
                <script src="{{asset('/js/editorDemo.js')}}"></script>
@endsection
