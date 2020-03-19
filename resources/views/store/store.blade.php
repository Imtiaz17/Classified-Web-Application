@extends('layouts.master')

@section('before_styles')
	<style type="text/css">
		#wrapper{background: #f8f8f8 !important ; height: auto !important; }
		.modal-body{margin: 10px 20px }
		.banner-img{
			background: url('/storeimage/{{$storedetails->store_cphoto}}');
			background-size: cover;
    		background-position: center;
    		background-repeat: no-repeat;
    		height: 300px;
    		width: 100%;
    		position: relative;
    		margin: 20px 0px;
		}
		.add-search{margin-top: -100px;}
		@media only screen and (max-width:991px) 
		{
			.add-search{margin-top:0px !important;}
		}
		.ads-list{padding: 8px 10px;}
		.modal p{color: #8c8a8a;}
		.shop-logo-area{ position: absolute; bottom: 0;left: 0; right: 0; margin: 1rem;display: table;}
		.shop-logo{ display: table-cell;width: 150px;}
		.shop-name{ display: table-cell;text-shadow: 2px 2px 5px #0a0000;color: #fff;padding-left: 10px}
		.shop-info p{ color: #707676;border-bottom: 1px solid #e4e4e4; padding-bottom: 8px; margin-bottom: 2px;}
		.shop-info i{ font-size: 18px; margin: 12px; color: #bfbcbc;}
		.src-btn{margin-left: -32px;width: 95%;padding: 2px; font-size: 23px;border: none;background: #3b5998;color: #fff; border-top-right-radius: 5px;border-bottom-right-radius: 5px;}
		.modal h3{font-size: 18px; border-bottom: 1px solid #e6e6e6;padding-bottom: 8px; margin: 10px 0px}
		span.open-day{width: 20%; float: left;}
		span.open-time{width: 80%; text-align: center; float: left;}
		h4.ads-list{border-bottom: 1px solid #e4e4e4; margin: 10px 0px;}
		.make-list{ width: 100%;clear: both;overflow: hidden;border-bottom: 1px solid #f5f5f5;padding: 8px 5px;}
		.off{color:#c51717;}
	</style>
@endsection

@section('content')
<div class="container" style="background: #fff !important;">
	<div class="row">
		<div class="col-md-12">
			<div class="banner-img">
				<div class="shop-logo-area">
					<div class="shop-logo">
						<img src="/storeimage/{{ $storedetails->store_logo }}" >
					</div>
					<div class="shop-name"><h2>{{ $storedetails->store_name }}</h2></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="shop-description">
				<p>{{ $storedetails->store_details }}</p>
			</div>
				<a type="button"  style="width: 100%;font-size: 15px;" data-toggle="modal" data-target="#Category">Details about this store </a>
		</div>

		<div class="col-md-4">
			<div class="shop-info">
				<p><i class="fa fa-clock-o"></i> 
					@foreach($storedetails->schedule as $key=>$val)
						@if($val->open_days==$today)
							@php
							$now = time();
							$ntime=date("h:i A", $now);
							$opentime=$val->opening_hours;
							$closetime=$val->closing_hours;
						@endphp
						@if($ntime> $opentime && $ntime< $closetime)
						<span>Open Now</span>
						@else
						<span>Now Close</span>
						@endif
							@break
					@else
						@if(count($storedetails->schedule)==$key+1)
					Close now
					@endif
						@endif
					@endforeach
					<br>
					@foreach($storedetails->schedule as $key =>$value)
					@if($value->open_days==$today)
					<span style="margin-left: 43px;">Open Today :</span>
					<span style="font-weight: 600;">{{$value->opening_hours}}-{{$value->closing_hours}}</span>
					@else
					@if(count($storedetails->schedule)==$key+1)
					<span style="margin-left: 43px;">Closed Today</span>
					@endif
					@endif
					@endforeach
				</p>
				<p><i class="fa fa-map-marker" style="margin-right: 19px;"></i><span>{{ $storedetails->address }}</span></p>
				<p><i class="fa fa-phone"></i> {{ $storedetails->phone }}</p>
				<p><i class="fa fa-envelope-o"></i> {{ $storedetails->email }}</p>
			</div>
		</div>
	</div><br/>
	<div class="row" style="margin-bottom: 50px;">
		<div class="col-md-8 add-search">
			<form action="#" method="get">
				<div class="row">
					<div class="col-xs-10">
					<input name="q" class="form-control keyword" type="text" placeholder="Seach from {{$storedetails->store_name}}" value="">
					</div>
					<div class="col-xs-2"><button class="src-btn" class=""><i class="fa fa-search"></i></button></div>
				</div>
			</form>
	<h3 class="ads-list">Ads of {{$storedetails->store_name}}</h3>
			<div class="make-list">
            	<div class="container">
            		<div class="row">
				    <div class="col-sm-2 col-xs-5 no-padding photobox">
				      <div class="add-image">
				        <span class="photo-count"><i class="fa fa-camera"></i> 2 </span>
				        <a href="#">
				          <img class="thumbnail no-margin" src="http://localhost:8000/uploads/files/bd/1/thumb-320x240-742961d8a448021b6f0b80aa22c56822.png" alt="img">
				        </a>
				      </div>
				    </div>
				    <div class="col-sm-9 col-xs-7 add-desc-box">
				      <div class="add-details">
				        <h5 class="add-title"><a href="#">Enterprise Plus </a></h5>
				        
				        <span class="info-row">
				          <span class="add-type business-ads tooltipHere" data-toggle="tooltip" data-placement="right" title="" data-original-title="Professional">
				            P
				          </span>&nbsp;
				            <span class="date"><i class="icon-clock"> </i> 3 days ago </span>
				            <span class="category">
				              - <a href="http://localhost:8000/search?c=47" class="info-link">Multimedia</a>
				            </span> - <span class="item-location"><i class="fa fa-map-marker"></i>&nbsp;
				            <a class="info-link">Dhaka</a> 
				            </span>
				        </span>
				      </div>

				      <span class="item-price">
				            645 ৳ 
				      </span>&nbsp;&nbsp;
				        <a class="btn btn-default btn-sm make-favorite" id="2"><i class="fa fa-heart"></i><span> Save </span></a>      
				    </div>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>



<!--Location Modal -->
<div class="modal fade" id="Category" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	Details of {{$storedetails->store_name}}
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
         <div class="modal-body">
        	<div class="shop-hours">
        		<h3>Open Time</h3>
        		<div class="row">
				    <div class="col-md-6">
				    	@foreach($schedule as $day)
				    	<p @if($day===$today) style="font-weight:600" @endif >{{$day->open_days}}</p>
				    	@endforeach
				    </div>
				    <div class="col-md-2">
					@foreach($schedule as $open)
					<p>{{$open->opening_hours}}</p>
					@endforeach
				    </div>
				    <div class="col-md-2">
					@foreach($schedule as $close)
					<p>{{$close->closing_hours}}</p>
			    	 @endforeach
				    </div>
				</div>
	      
	        </div><br/>
	        <div class="address">
	        	<h3>Address</h3>
	        	<p>{{ $storedetails->address }}</p>
	        </div>

	        <div class="description">
	        	<h3>Description</h3>
	        	<p>{{ $storedetails->store_details }}</p>
	        </div>

	        <div class="website">
	        	<h3>Email:</h3>
				<a href="#"> {{ $storedetails->email }} </a>
	        </div>
        </div>
        {{-- <div class="modal-body">
        	<div class="row">
				    <div class="col-md-6">
				    	@foreach($days as $day)
				    	<p @if($day===$today)style="font-weight:600" @endif >{{$day}}</p>
				    	@endforeach
				    </div>
				    <div class="col-md-2">
			    	 @foreach ($openhours as $oh)
			    	 @if($oh)
			    	 <p>{{$oh}}</p>
			    	 @else
			    	 <p>-</p>
			    	 @endif
			    	 @endforeach
				    </div>
				    <div class="col-md-2">
			    	 @foreach ($closehours as $ch)
			    	 @if($ch)
			    	 <p>{{$ch}}</p>
			    	 @else
			    	 <p>-</p>
			    	 @endif
			    	 @endforeach
				    </div>
				</div>
        </div> --}}
      </div>
    </div>
</div>
@endsection