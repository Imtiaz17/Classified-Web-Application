@extends('layouts.master')
@section('after_styles')
  <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
<style>

	.opentimepicker
	{
		text-align: center;
	}
	.closetimepicker
	{
		text-align: center;
	}
	.form-check-label {
    padding-left:1rem;
    margin-bottom: 0;
    cursor: pointer;
}

</style>
@endsection
@php
@endphp
@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 page-sidebar">
					@include('account.inc.sidebar')
				</div>
				<!--/.page-sidebar-->

				<div class="col-sm-9 page-content">
					@if (isset($errors) and $errors->any())
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
					@include('flash::message')
					<div class="inner-box">
						<div class="row">
							<div class="col-md-5 col-xs-4 col-xxs-12">
							</div>
							<div class="col-md-7 col-xs-8 col-xxs-12">
							<div class="header-data text-center-xs">
								<!-- Traffic data -->
								<div class="hdata">

								</div>
							</div>
						</div>

						</div>
					</div>
					<div class="inner-box">
						<div class="panel-group" id="accordion">
							<!-- USER -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#userPanel" data-toggle="collapse" data-parent="#accordion">Shop Details</a></h4>
								</div>

							<div class="panel-collapse collapse {{ (old('panel')=='' or old('panel')=='userPanel') ? 'in' : '' }}" id="userPanel">
									<div class="panel-body">
										@if ($usershop->isNotEmpty())
										 @foreach ($usershop as $item)
										 @php
											 $openday=[];
											 $oh=[];
											 $ch=[];
											 $od=App\Models\Store::find($item->id)->schedule;
											 foreach ($od as $item2){
												 $openday[]=$item2->open_days;
												 $oh[$item2->open_days]=$item2->opening_hours;
												 $ch[$item2->open_days]=$item2->closing_hours;
											 }		
											@endphp
										<form name="details" class="form-horizontal" role="form" method="post" action="{{route('shopinfoupdate',$item->id)}}" enctype="multipart/form-data">
										    {{csrf_field()}}
											{{method_field('PATCH')}}
											 

											<div class="form-group required">
												<label class="col-sm-3 control-label">Shop Name<sup>*</sup></label>
												<div class="col-sm-9">
													<input name="name" type="text" class="form-control" placeholder="" value="{{$item->store_name}}">
													<input name="store_id" type="hidden" value="{{$item->id}}">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Shop Address<sup>*</sup></label>
												<div class="col-sm-9">
													<input name="address" type="text" class="form-control" placeholder="" value="{{$item->address}}">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Shop Phone no<sup>*</sup></label>
												<div class="col-sm-9">
													<input name="phone" type="text" class="form-control" placeholder="" value="{{$item->phone}}">
												</div>
											</div>
												<div class="form-group required">
												<label class="col-sm-3 control-label">Shop email<sup>*</sup></label>
												<div class="col-sm-9">
													<input name="email" type="text" class="form-control" placeholder="" value="{{$item->email}}">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Store Logo<sup>*</sup></label>
												<div class="col-sm-9">
													<input id="storelogo" name="storelogo" type="file">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Store cover photo<sup>*</sup></label>
												<div class="col-sm-9">
													<input id="storecp" name="storecp" type="file">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-md-3 col-sm-3 control-label">Shop Opeing day & hours<sup>*</sup></label>
												<div class="col-md-9 col-sm-9">
													<div class="row">
														<div class="col-md-4 col-sm-6">
															@foreach ($days as $day)
															
															<div class="form-check">
															    <input type="checkbox" name="days[{{$day}}]" id="{{$day}}" {{in_array($day,$openday)?"checked":""}}   class="form-check-input"
															    value="{{$day}}">
															    <label class="form-check-label" for="{{$day}}">{{$day}}</label>
															 </div>
														
															@endforeach
														</div>
														<div class="col-md-4 col-sm-3">
											
															@foreach ($days as $day)
															<input type="text" class="opentimepicker" value="{{in_array($day,$openday)?"$oh[$day]":""}}" name="opentime[{{$day}}]"placeholder="opening time">
															@endforeach
															
														</div>
														<div class="col-md-4 col-sm-3">
															@foreach ($days as $day)
															<input type="text" class="closetimepicker" value="{{in_array($day,$openday)?"$ch[$day]":""}}" name="closetime[{{$day}}]" placeholder="Closing time">
															@endforeach
															 {{--  @php
															 $ch=explode(",", $item->closing_hours);
															 $countch=count($ch);
															 @endphp
															 	@foreach ($ch as $ch)
																<input type="" class="closetimepicker" value="{{$ch}}" name="closetime[]"placeholder="Closing time">

															@endforeach
															@for ($i = 0; $i <7-$countch ; $i++)
																<input type="" class="closetimepicker" value="" name="closetime[]"placeholder="Closing time">
															@endfor  --}}
														</div>
													</div>
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Shop Details<sup>*</sup></label>
												<div class="col-sm-9">
													<textarea name="details" type="text" class="form-control" placeholder="Shop details">{{$item->store_details}}
													</textarea>
												</div>
											</div>

											<input type="submit" name="" class="btn btn-info pull-right">

										</form>
										@endforeach
										@else
										<form name="details" class="form-horizontal" role="form" method="POST" action="{{ url('storeinfo')}}"  enctype="multipart/form-data">
												{!! csrf_field() !!}
											<div class="form-group required">
												<label class="col-sm-3 control-label">Shop Name<sup>*</sup></label>
												<div class="col-sm-9">
													<input name="name" type="text" class="form-control" placeholder="" value="">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Shop Address<sup>*</sup></label>
												<div class="col-sm-9">
													<input name="address" type="text" class="form-control" placeholder="" value="">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Shop Phone no<sup>*</sup></label>
												<div class="col-sm-9">
													<input name="phone" type="text" class="form-control" placeholder="" value="">
												</div>
											</div>
												<div class="form-group required">
												<label class="col-sm-3 control-label">Shop email<sup>*</sup></label>
												<div class="col-sm-9">
													<input name="email" type="text" class="form-control" placeholder="" value="">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Store Logo<sup>*</sup></label>
												<div class="col-sm-9">
													<input id="storelogo" name="storelogo" type="file">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Store cover photo<sup>*</sup></label>
												<div class="col-sm-9">
													<input id="storecp" name="storecp" type="file">
												</div>
											</div>
											<div class="form-group required">
												<label class="col-md-3 col-sm-3 control-label">Shop Opeing day & hours<sup>*</sup></label>
												<div class="col-md-9 col-sm-9">
													@foreach ($days as $day)
													<div class="row">
														<div class="col-md-4 col-sm-6">
															<div class="form-check">
															    <input type="checkbox" name="days[]" id="{{$day}}" class="form-check-input"
															    value="{{$day}}">
															    <label class="form-check-label" for="{{$day}}">{{$day}}</label	>
															 </div>
														</div>
														<div class="col-md-4 col-sm-3">
																<input type="" class="opentimepicker" value="" name="opentime[{{$day}}]" placeholder="opening time">
														</div>
														<div class="col-md-4 col-sm-3">
																<input type="" class="closetimepicker" value="" name="closetime[{{$day}}]" placeholder="Closing time">
														</div>
														
													</div>
													@endforeach
												</div>
											</div>
											<div class="form-group required">
												<label class="col-sm-3 control-label">Shop Details<sup>*</sup></label>
												<div class="col-sm-9">
													<textarea name="details" type="text" class="form-control" placeholder="Shop details"></textarea>
												</div>
											</div>
											<input type="submit" name="" class="btn btn-info pull-right">
										</form>
										@endif
									</div>
								</div>
								</div>
						</div>
					</div>
				</div>
				<!--/.page-content-->
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
@endsection

@section('after_scripts')
 <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
 <script>
$(document).ready(function() {
    $("#storelogo").fileinput({showCaption: false,showUpload: false, dropZoneEnabled: false});
    $("#storecp").fileinput({showCaption: false,showUpload: false, dropZoneEnabled: false});
});
</script>
<script type="text/javascript">
            // Get Upload Url
          @if ($usershop->isNotEmpty())
           @foreach ($usershop as $item)
            $("#storelogo").fileinput(
            	{
            		showCaption: false,
            		showUpload: false,
            		dropZoneEnabled: false,
            		initialPreview: [
            		  "storeimage/{{ $item->store_logo }}"
            		],
            		initialPreviewAsData: true,
               		initialPreviewFileType: 'image',
            	});
	            $("#storecp").fileinput(
	            	{
	            		showCaption: false,
	            		showUpload: false,
	            		dropZoneEnabled: false,
	            		initialPreview: [
	            		  "storeimage/{{ $item->store_cphoto }}"
	            		],
	            		initialPreviewAsData: true,
	               		initialPreviewFileType: 'image',
	            	});
            @endforeach
          @endif
             
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
    $('input.opentimepicker').timepicker({
    	 timeFormat: 'h:mm p',
    	 interval: 30,
    	startTime: '10',
    	dynamic: false,
    dropdown: true,
    scrollbar: true
    });
     $('input.closetimepicker').timepicker({
    	 timeFormat: 'h:mm p',
    	 interval: 30,
    	startTime: '5',
    	dynamic: false,
	    dropdown: true,
	    scrollbar: true
    });
});
</script>
{{-- <script type="text/javascript">
	if (.form-check-input.is(':checked')) {
	}else
	{
		.form-check-input.addClass('range-day-disabled');
	}
</script> --}}
<script>
	// $('#Saturday').on( "click", function(){
	// 	if(this.checked){
	// 		$(".opentimepicker:nth-child(1)").prop('disabled', false);
	// 		 //$(".closetimepicker:nth-child(1)").prop('disabled', false);

	// 	}else
	// 	$(".opentimepicker:first").prop('disabled', true);
	// 	$(".closetimepicker:first").prop('disabled', true);

	// })
	// $('#Sunday').on( "click", function(){
	// 	if($(this).is(":checked")){
	// 	$(".opentimepicker:nth-child(2)").prop('disabled', false);
	// 	$(".closetimepicker:nth-child(2)").prop('disabled', false);
	// 	}else
	// 	$(".opentimepicker:nth-child(2)").prop('disabled', true);
	// 	$(".closetimepicker:nth-child(2)").prop('disabled', true);
	// })



</script>
@endsection
