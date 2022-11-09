@extends('layouts.admin_app')
@section('title', 'Create CMS')

@section('content')
<link rel="stylesheet" href="{{asset('/vendors/summernote/dist/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{asset('/vendors/quill/quill.snow.css')}}">
<link rel="stylesheet" href="{{asset('/vendors/simplemde/simplemde.min.css')}}">
<style>
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
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <h4 class="card-title">Add CMS</h4>
                            <form class="forms-sample" id="addCMS" method="post" action="{{route('cms.store')}}"
                                  enctype='multipart/form-data'>
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title_en">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                               placeholder="Title">
                                    </div>

                                    <div class="form-group col-md-6">

                                        <label class="language">Language</label>
                                        <select class="form-control" name="language" id="language">
                                            <option value=''>Select language</option>
                                            <option value="en">English</option>
                                            <option value="es">Spanish</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">

                                        <label class="">Details</label>
                                        <textarea class="form-control" id="details_en" rows="2" name="details"
                                                  placeholder="Enter Details"></textarea>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>File upload</label>
                                        <input type="file" id="img" name="image" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled
                                                   placeholder="Upload Image">
                                            <span class="input-group-append">
                              <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                                        </div>
                                        <label id="img-error" class="error" for="img"></label>
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
                                                               id="active" value="0" checked>
                                                        Active
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="status"
                                                               id="in-active" value="1">
                                                        In-active
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                        <a class="btn btn-light" href="{{route('cms.index')}}">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('page_js')
            <script src="{{asset('/vendors/tinymce/tinymce.min.js')}}"></script>
            <script src="{{asset('/js/jquery-1.7.1.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('/js/jquery.validate.min.js')}}"></script>
            <script src="{{asset('/vendors/simplemde/simplemde.min.js')}}"></script>
            <script src="{{asset('/vendors/summernote/dist/summernote-bs4.min.js')}}"></script>
            <script src="{{asset('/vendors/quill/quill.min.js')}}"></script>
            <script src="{{asset('/js/editorDemo.js')}}"></script>
            <script>
                $('#addCMS').validate({
                    // initialize the plugin
                    rules: {
                        title: {
                            required: true,
                            maxlength:25
                        },
                        details: {
                            required: true
                        },
                        language: {
                            required: true
                        },
                        image: {
                            required: true
                        },
                    }
                });
            </script>
@endsection
