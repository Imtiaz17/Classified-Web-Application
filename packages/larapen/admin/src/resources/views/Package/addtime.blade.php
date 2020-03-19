@extends('admin::layout')

@section('after_styles')

@endsection

@section('header')
    <section class="content-header">
        <h1>
           List of Packages
        </h1>
        <ol class="breadcrumb">
           {{--  <li><a href="{{ url(config('larapen.admin.route_prefix', 'admin').'/dashboard') }}">Admin</a></li>
            <li class="active">Store request </li> --}}
        </ol>
    </section>
@endsection

@section('content')
 <section class="content">
    <div class="row">
    	   <div class="col-md-8 col-md-offset-2">
            <a href="{{route('package.index')}}"><i class="fa fa-angle-double-left"></i> Back to all  <span class="text-lowercase">packages</span></a><br><br>
            <form method="POST" action="{{ route('storetimelimit') }}"  enctype="multipart/form-data">
              {!! csrf_field() !!}
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
                        <h3 class="box-title">Add time limit</h3>
                    </div>
                    <div class="box-body" >
                    	<div class="row" id="box">
                    		<div class="next">
		                        <div class="form-group col-md-6">
		                            <label>Day</label>
		                            <input type="text" name="day[]" class="form-control" placeholder="how much day the promotion will run?">
		                        </div>
		                        <div class="form-group col-md-6">
		                            <label>Price</label>
		                            <input type="text" name="price[]" class="form-control" placeholder="Price of the promotion">
		                        </div>
		                        <input type="hidden" name="name" value="{{Request::route('package')}}">
		                    </div>
                        </div>
                    </div>
                    <div class="box-footer">
                    <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> Save</span></button>
                </div>
                </div>
            </form>
            <div class="row" style="padding:0px 20px;float: right;">
            	 <button id="add" class="btn btn-default add-more  uppercase" type="button">+ Add another </button> 
            	 <button class="delete btn btn-danger uppercase">- Remove field</button>
            </div>
        </div>
	</div>
</section>

@endsection


@section('after_scripts')
<script type="text/javascript">
	  $(document).ready(function() {
  $(".delete").hide();
  //when the Add Field button is clicked
  $("#add").click(function(e) {
    $(".delete").fadeIn("1500");
    //Append a new row of code to the "#items" div
    $("#box").append(
    	'<div class="next"><div class="form-group col-md-6"><label>Day</label><input type="text" name="day[]" class="form-control" placeholder="how much day the promotion will run?"></div><div class="form-group col-md-6"><label>Price</label><input type="text" name="price[]" class="form-control" placeholder="Price of the promotion"></div></div>'
    );
  });
  $("body").on("click", ".delete", function(e) {
    $(".next").last().remove();
  });
});

</script>

@endsection
