@extends('layouts.admin_app')
@section('title', 'Create Trader')
<style>
    .error {
        color: red;
    }
</style>
@section('content')
@php
$lang = ['en'=>"English",'id'=>'Indonesian'];
$old = session()->getOldInput();
$i=0;
@endphp

    <div class="main-panel">
        <div class="content-wrapper">
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

                            <h4 class="card-title">Add Trader</h4>
                            
                            <form class="forms-sample" id="addTrader" method="post" action="{{route('traders.store')}}"
                                  enctype='multipart/form-data'>
                                @csrf
                                <div class="row">
                                    @foreach($lang as $k=>$ln)
                                    {!! Form::hidden('lang[]',$k,['class'=>'form-control']) !!}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Name({{$ln}})</label>
                                            <input type="text" {{$ln=='English' ? "required" : ""}} class="form-control" id="name" name="name[]" value="@if(isset($old['name'])){{ $old['name'][$i] }} @endif"
                                            placeholder="enter trader name ({{$ln}})">
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Subtitle({{$ln}})</label>
                                            <input type="text" {{$ln=='English' ? "required" : ""}} class="form-control" id="subtitle" name="subtitle[]" value="@if(isset($old['subtitle'])){{ $old['subtitle'][$i] }} @endif"
                                            placeholder="enter trader subtitle ({{$ln}})">
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Description({{$ln}})</label>
                                            <textarea class="form-control editor_description" {{$ln=='English' ? "required" : ""}} name="description[]"  value=""
                                            placeholder="enter description ({{$ln}})" rows="4">@if(isset($old['description'])){{ $old['description'][$i] }} @endif</textarea>
                                        </div>
                                    </div>
                                    @php $i++; @endphp
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>MT5 Username</label>
                                            <input type="text" class="form-control" id="mt5_username" name="mt5_username"
                                            placeholder="enter MT5 username" value="{{old('mt5_username')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>MT5 Password</label>
                                            <input type="text" class="form-control" id="mt5_password" name="mt5_password"
                                            placeholder="enter MT5 password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Minimum Amount</label>
                                            <input type="text" class="form-control" id="minimum_amount" name="minimum_amount"
                                            placeholder="enter minimum amount" 
                                            min="0" maxlength="23"  value="{{old('minimum_amount')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Maximum Amount</label>
                                            <input type="text" class="form-control" id="maximum_amount" name="maximum_amount" min="0" 
                                            placeholder="enter maximum amount" maxlength="28"  value="{{old('maximum_amount')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label>Profile Picture</label>
                                            <input type="file" id="img" name="profile_picture" class="file-upload-default">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled
                                                placeholder="Upload Profile">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                </span>
                                            </div>
                                            <div>
                                                <label id="" class="error" for="img"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Graph Picture</label>
                                            <input type="file" id="img1" name="graph_picture" class="file-upload-default">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled
                                                placeholder="Upload Graph">

                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                </span>
                                            </div>
                                            <div>
                                                <label id="" class="error" for="img1"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Best Trader Image</label>
                                            <input type="file" id="img1" name="best_trader_image" class="file-upload-default" accept=".jpg,.png.gif">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled
                                                placeholder="Upload Best Trader">

                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                </span>
                                            </div>
                                            <div>
                                                <label id="" class="error" for="img1"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="form-label mt-2">Status</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="status"
                                                            id="active" value="0" checked>
                                                            Enable
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="status"
                                                            id="in-active" value="1">
                                                            Disable
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                                <a class="btn btn-light" href="{{route('traders.index')}}">Back</a>
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
                
                // CKEDITOR.replace( '.editor_description');

                [].forEach
                .call(document.querySelectorAll('.editor_description'), 
                    function(v) { CKEDITOR.replace(v);
                    });
                jQuery.validator.addMethod("extension", function(value, element) {
                    if(value){
                        
                        var ext = $(element).val().split('.').pop().toLowerCase();
                        if(value && $.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                            return false;
                        }
                    }
                  return true;
                }, "Please choose image files only.");

                jQuery.validator.addMethod("twoDigitDecimal", function(value, element) {
                    var length = value.substring(value.indexOf('.'), value.indexOf('.').length).length;
                    // console.log(length);
                    if(value.indexOf('.') != -1 && length > 3){
                        console.log('test');
                        return false;
                    }
                  return true;
                }, "Number with 2 decimal allowed only.");

                function forceNumber(element) {
                  element
                  .data("oldValue", '')
                  .bind("paste", function(e) {
                      var validNumber = /^[-]?\d+(\.\d{1,2})?$/;
                      element.data('oldValue', element.val())
                      setTimeout(function() {
                        if (!validNumber.test(element.val()))
                          element.val(element.data('oldValue'));
                    }, 0);
                  });
                  element
                  .keypress(function(event) {
                      var text = $(this).val();
                    if ((event.which != 46 || text.indexOf('.') != -1) && //if the keypress is not a . or there is already a decimal point
                    ((event.which < 48 || event.which > 57) && //and you try to enter something that isn't a number
                      (event.which != 45 || (element[0].selectionStart != 0 || text.indexOf('-') != -1)) && //and the keypress is not a -, or the cursor is not at the beginning, or there is already a -
                      (event.which != 0 && event.which != 8))) { //and the keypress is not a backspace or arrow key (in FF)
                        event.preventDefault(); //cancel the keypress
                    }

                    if ((text.indexOf('.') != -1) && (text.substring(text.indexOf('.')).length > 2) && //if there is a decimal point, and there are more than two digits after the decimal point
                    ((element[0].selectionStart - element[0].selectionEnd) == 0) && //and no part of the input is selected
                    (element[0].selectionStart >= element.val().length - 2) && //and the cursor is to the right of the decimal point
                    (event.which != 45 || (element[0].selectionStart != 0 || text.indexOf('-') != -1)) && //and the keypress is not a -, or the cursor is not at the beginning, or there is already a -
                    (event.which != 0 && event.which != 8)) { //and the keypress is not a backspace or arrow key (in FF)
                        event.preventDefault(); //cancel the keypress
                    }
                });
              }
        forceNumber($('#minimum_amount'));
        forceNumber($('#maximum_amount'));
                jQuery.validator.addMethod("sixDigitDecimal", function(value, element) {
                    var length = 20;
                    var decimalLength = 0;
                    if(value.indexOf('.') != -1){
                        decimalLength = value.substring(value.indexOf('.'), value.indexOf('.').length).length;
                    }
                    length += decimalLength;
                    if(value.length > length){
                        return false;
                    }
                  return true;
                }, "No more than 20 digits allowed");

                jQuery.validator.addMethod("eightDigitDecimal", function(value, element) {
                    var length = 25;
                    var decimalLength = 0;
                    if(value.indexOf('.') != -1){
                        decimalLength = value.substring(value.indexOf('.'), value.indexOf('.').length).length;
                    }
                    length += decimalLength;
                    if(value.length > length){
                        return false;
                    }
                  return true;
                }, "No more than 25 digits allowed");

                jQuery.validator.addMethod("greaterThan", function(value, element) {
                    
                    if(parseFloat(value) < parseFloat($('#minimum_amount').val())){
                        return false;
                    }
                  return true;
                }, "Maximum amount must be greater than minimum amount");

                 jQuery.validator.addMethod("lessThan", function(value, element) {
                    
                    if($('#maximum_amount').val() != '' && parseFloat(value) > parseFloat($('#maximum_amount').val())){
                        return false;
                    }
                  return true;
                }, "Minimum amount must be less than maximum amount");

                $('#addTrader').validate({
                    // initialize the plugin
                    rules: {
                        "name[]": {
                            required: true,
                            maxlength:15
                        },
                        "subtitle[]": {
                            required: true,
                        },
                        language: {
                            required: true,
                        },
                        profile_picture: {
                            required: true
                        },
                        graph_picture: {
                            required: true
                        },
                        best_trader_image: {
                            // required: true,
                            extension:true
                        },
                        status: {
                            required: true
                        },
                        // mt5_username: {
                        //     required: true
                        // },
                        // mt5_password: {
                        //     required: true
                        // },
                        minimum_amount: {
                            required: true,
                            number  : true,
                            min     : 0,
                            lessThan: true,
                            twoDigitDecimal: true,
                            sixDigitDecimal: true
                        },
                        maximum_amount: {
                            required: true,
                            number  : true,
                            min     : 0,
                            greaterThan: true,
                            twoDigitDecimal: true,
                            eightDigitDecimal: true
                        }
                    }
                });
            </script>
            <script type="text/javascript">
                $('#minimum_amount').on('keyup',function(){
                    var amount = $(this).val();
                    $('#maximum_amount').attr('min',amount);
                });
            </script>
@endsection
