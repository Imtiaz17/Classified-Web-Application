@extends('admin::layout')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
   {{--  <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endsection

@section('header')
    <section class="content-header">
        <h1>
          Add package
        </h1>
        <ol class="breadcrumb">
           {{--  <li><a href="{{ url(config('larapen.admin.route_prefix', 'admin').'/dashboard') }}">Admin</a></li>
            <li class="active">Store request </li> --}}
        </ol>
    </section>
@endsection

@section('content')
    <!-- Default box -->
 <section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{route('package.index')}}"><i class="fa fa-angle-double-left"></i> Back to all  <span class="text-lowercase">packages</span></a><br><br>
            <form method="POST" action="{{ route('package.update',$package->id) }}">
              {!! csrf_field() !!}
               {{method_field('PATCH')}}
                <div class="box">
                     @if ($errors->any())
                      <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                      </div><br />
                    @endif
                    <div class="box-header with-border">
                        <h3 class="box-title">Add a new  package</h3>
                    </div>
                    <div class="box-body row">
                        <div class="form-group col-md-12">
                            <label>Name</label>
                            <input type="text" name="name" value="{{$package->name}}" class="form-control" placeholder="Package name">

                        </div>
                        <div class="form-group col-md-12">
                            <label>Description</label>
                            <input type="text" name="description" value="{{$package->description}}" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                            <select class="form-control" name="active">
                                <option value="0" {{$package->active == 0 ? 'selected' : ''}}>Active</option>
                                 <option value="1" {{$package->active == 1 ? 'selected' : ''}}>Deactive</option>
                         
                            </select>
                        </div>
                         <div class="form-group col-md-12 image" data-preview="#picture" data-aspectratio="0" data-crop="">
                        <div>
                            <label>Picture</label>
                        </div>
                        <!-- Wrap the image or canvas element with a block element (container) -->
                        <div class="row">
                            <div class="col-sm-6" style="margin-bottom: 20px;">
                                <img id="mainImage" src= "{{ asset('uploads/'.$package->picture) }}" width="120px" height="80px" alt="LP">
                            </div>
                                </div>
                        <div class="btn-group">
                            <label class="btn btn-primary btn-file">
                                Choose file <input type="file" accept="image/*" id="uploadImage" class="hide">
                                <input type="hidden" id="hiddenImage" name="picture" value="">
                            </label>
                                    <button class="btn btn-danger" id="remove" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                        
                        
                        </div>
                            @if(!empty($durations))
                                @foreach ($durations as $element)
                            
                                    <div class="next">
                                        <div class="form-group col-md-6">
                                            <label>Day</label>
                                            <input type="text" value="{{$element->duration}}" name="day[]"  class="form-control" placeholder="how much day the promotion will run?">
                                        </div>
                                          <input type="hidden" value="{{$element->id}}" name="durationid[]" >
                                        <div class="form-group col-md-6">
                                            <label>Price</label>
                                            <input type="text" value="{{$element->price}}" name="price[]" class="form-control" placeholder="Price of the promotion">
                                        </div>
                                    </div>                                
                                @endforeach
                            @endif
                    </div>
                    <div class="box-footer">
                    <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i>Update</span></button>
                    <a href="{{route('package.index') }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Cancel</span></a>
                </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('after_scripts')
     <script src="{{ asset('vendor') }}/admin/cropper/dist/cropper.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            // Loop through all instances of the image field
            $('.form-group.image').each(function(index){
                // Find DOM elements under this form-group element
                var $mainImage = $(this).find('#mainImage');
                var $uploadImage = $(this).find("#uploadImage");
                var $hiddenImage = $(this).find("#hiddenImage");
                var $rotateLeft = $(this).find("#rotateLeft")
                var $rotateRight = $(this).find("#rotateRight")
                var $zoomIn = $(this).find("#zoomIn")
                var $zoomOut = $(this).find("#zoomOut")
                var $reset = $(this).find("#reset")
                var $remove = $(this).find("#remove")
                // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
                var options = {
                    viewMode: 2,
                    checkOrientation: false,
                    autoCropArea: 1,
                    responsive: true,
                    preview : $(this).attr('data-preview'),
                    aspectRatio : $(this).attr('data-aspectRatio')
                };
                var crop = $(this).attr('data-crop');
                
                // Hide 'Remove' button if there is no image saved
                if (!$mainImage.attr('src')){
                    $remove.hide();
                }
                // Initialise hidden form input in case we submit with no change
                // $hiddenImage.val($mainImage.attr('src'));
                
                
                // Only initialize cropper plugin if crop is set to true
                if(crop){
                    
                    $remove.click(function() {
                        $mainImage.cropper("destroy");
                        $mainImage.attr('src','');
                        $hiddenImage.val('');
                        $rotateLeft.hide();
                        $rotateRight.hide();
                        $zoomIn.hide();
                        $zoomOut.hide();
                        $reset.hide();
                        $remove.hide();
                    });
                } else {
                    
                    $(this).find("#remove").click(function() {
                        $mainImage.attr('src','');
                        $hiddenImage.val('');
                        $remove.hide();
                    });
                }
                
                $uploadImage.change(function() {
                    var fileReader = new FileReader(),
                        files = this.files,
                        file;
                    
                    if (!files.length) {
                        return;
                    }
                    file = files[0];
                    
                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $uploadImage.val("");
                            if(crop){
                                $mainImage.cropper(options).cropper("reset", true).cropper("replace", this.result);
                                // Override form submit to copy canvas to hidden input before submitting
                                $('form').submit(function() {
                                    var imageURL = $mainImage.cropper('getCroppedCanvas').toDataURL(file.type);
                                    $hiddenImage.val(imageURL);
                                    return true; // return false to cancel form action
                                });
                                $rotateLeft.click(function() {
                                    $mainImage.cropper("rotate", 90);
                                });
                                $rotateRight.click(function() {
                                    $mainImage.cropper("rotate", -90);
                                });
                                $zoomIn.click(function() {
                                    $mainImage.cropper("zoom", 0.1);
                                });
                                $zoomOut.click(function() {
                                    $mainImage.cropper("zoom", -0.1);
                                });
                                $reset.click(function() {
                                    $mainImage.cropper("reset");
                                });
                                $rotateLeft.show();
                                $rotateRight.show();
                                $zoomIn.show();
                                $zoomOut.show();
                                $reset.show();
                                $remove.show();
                                
                            } else {
                                $mainImage.attr('src',this.result);
                                $hiddenImage.val(this.result);
                                $remove.show();
                            }
                        };
                    } else {
                        alert("Please choose an image file.");
                    }
                });
                
            });
        });
    </script>
@endsection


