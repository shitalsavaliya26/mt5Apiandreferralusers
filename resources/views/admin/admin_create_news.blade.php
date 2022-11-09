@extends('layouts.admin_app')
@section('title', 'Create News')

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
        <div class="content-wrapper">
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

            <h4 class="font-weight-bold mt-2">Add News</h4>
            <br/>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form class="forms-sample" name="editNewsForm" id="addNews" method="post"
                                  action="{{route('news.store')}}" enctype='multipart/form-data'>
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
                                            <!-- <option value="es">Spanish</option> -->
                                            <option value="id">Indonesian</option>
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
                                    </div>
                                </div>
                                <br>
                                <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                <a class="btn btn-light" href="{{route('news.index')}}">Back</a>
                            </form>
                        </div>
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
            <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
            <script>
                // ACF is enabled by default regardless whether toolbar configuration is provided or not.
                // By having a smaller number of features enabled in the toolbar it should be easier to understand how ACF works.
                CKEDITOR.config.toolbar = [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
                  },
                  {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                  },
                  {
                    name: 'links',
                    items: ['Link', 'Unlink']
                  },
                 
                  {
                    name: 'document',
                    items: ['Source']
                  },
                  {
                    name: 'about',
                    items: ['About']
                  }
                ];
                // Disable paste filter to avoid confusion on browsers on which it is enabled by default and may affect results.
                // Read more in https://ckeditor.com/docs/ckeditor4/latest/guide/dev_advanced_content_filter-section-filtering-pasted-and-dropped-content
                CKEDITOR.config.pasteFilter = null;

                CKEDITOR.config.height = 150;
                
              </script>
            <script>
                CKEDITOR.replace( 'details', {
                    // filebrowserUploadUrl: "{{route('upload_news_image', ['_token' => csrf_token() ])}}",
                    // filebrowserUploadMethod: 'form'
                });

                $('#addNews').validate({
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
                        image: {
                            required: true
                        },
                    }
                });
            </script>
@endsection
