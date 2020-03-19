@extends('layouts.master')

@section('before_styles')
	<style type="text/css">
		#wrapper{background: #f8f8f8 !important ; height: auto !important; }
		.modal-body{margin: 10px 20px }
		.banner-img{
			background: url("{{ asset('images/bg.jpg') }}");
			background-size: cover;
    		background-position: center;
    		background-repeat: no-repeat;
    		height: 300px;
    		width: 100%;
    		position: relative;
    		margin: 20px 0px;
		}
		.modal p{clear: both; padding: 5px;color: #8c8a8a;}
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
						<img src="{{asset('uploads/app/logo/logo-5dd0cffb8c7ff.png') }}">
					</div>
					<div class="shop-name"><h2>Imtiaz vair store</h2></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			
			SAVE MONEY GET RELAX
			<div class="shop-description">
				<p>Welcome to Hadisa Car Hat.
				<br>
				Whatever your budget, we are providing your vehicle with sincerity. We are giving you the assurance about the vehicle technical support and documents. We are very glad to inform you that we are providing recondition car also. You can choose your car and verify it by your trusted one. please visit us or call us for any kind of choice.</p>
			</div>
			
			<a type="button"  style="width: 100%;font-size: 15px;" data-toggle="modal" data-target="#Category">More description </a>
			
		</div>
		<div class="col-md-4">
			<div class="shop-info">
				<p><i class="fa fa-clock-o"></i> এখন চালু<br>
					<span>আজ খোলা:&nbsp;</span>
					<span class="t-bold">১০:০০ এএম&nbsp;–&nbsp; ৯:০০ পিএম</span>
				</p>
				<p><i class="fa fa-map-marker"></i> Mahmudhpur, Vuigor, Fotulla, Narayanganj</p>
				<p><i class="fa fa-phone"></i> 0182343985475</p>
				<p><i class="fa fa-envelope-o"></i> neyamulkn@gmail.com</p>
			</div>
		</div>
	</div><br/>

	<div class="row">
		<div class="col-md-8">

			<form action="#" method="get">
				<div class="row">
				
					<div class="col-xs-10">
					<input name="q" class="form-control keyword" type="text" placeholder="Search ads" value="">
					</div>
					<div class="col-xs-2"><button class="src-btn" class=""><i class="fa fa-search"></i></button></div>
				</div>
			</form>
			<h4 class="ads-list">Imtiaz store এর বিজ্ঞাপন সমূহ (1-25 এর 80)</h4>

			<div class="make-list">
            	<div class="row">
				    <div class="col-sm-2 col-xs-5 photobox">
				      <div class="add-image">
				        <span class="photo-count"><i class="fa fa-camera"></i> 2 </span>
				        <a href="#">
				          <img class="thumbnail no-margin" src="http://localhost:8000/uploads/files/bd/2/thumb-320x240-4cfd8f3407d6940e7ea998f081b442fa.jpg" alt="img">
				        </a>
				      </div>
				    </div>
				    <div class="col-sm-9 col-xs-7 add-desc-box">
				      <div class="add-details">
				        <h5 class="add-title"><a href="#">Inventory management system </a></h5>
				        
				        <span class="info-row">
				          <span class="add-type business-ads tooltipHere" data-toggle="tooltip" data-placement="right" title="" data-original-title="Professional">
				            P
				          </span>&nbsp;
				            <span class="date"><i class="icon-clock"> </i> 3 days ago </span>
				            <span class="category">
				              - <a href="http://localhost:8000/search?c=47" class="info-link">Multimedia</a>
				            </span> - <span class="item-location"><i class="fa fa-map-marker"></i>&nbsp;
				            <a href="http://localhost:8000/search?l=1185241" class="info-link">Dhaka</a> 
				            </span>
				        </span>
				      </div>

				      <span class="item-price">
				            ৳ 645
				      </span>&nbsp;&nbsp;
				        <a class="btn btn-default btn-sm make-favorite" id="2"><i class="fa fa-heart"></i><span> Save </span></a>      
				    </div>
				</div>
			</div>

			<div class="make-list">
            	<div class="row">
				    <div class="col-sm-2 col-xs-5 photobox">
				      <div class="add-image">
				        <span class="photo-count"><i class="fa fa-camera"></i> 2 </span>
				        <a href="#">
				          <img class="thumbnail no-margin" src="http://localhost:8000/uploads/files/bd/2/thumb-320x240-4cfd8f3407d6940e7ea998f081b442fa.jpg" alt="img">
				        </a>
				      </div>
				    </div>
				    <div class="col-sm-9 col-xs-7 add-desc-box">
				      <div class="add-details">
				        <h5 class="add-title"><a href="#">Inventory management system </a></h5>
				        
				        <span class="info-row">
				          <span class="add-type business-ads tooltipHere" data-toggle="tooltip" data-placement="right" title="" data-original-title="Professional">
				            P
				          </span>&nbsp;
				            <span class="date"><i class="icon-clock"> </i> 3 days ago </span>
				            <span class="category">
				              - <a href="http://localhost:8000/search?c=47" class="info-link">Multimedia</a>
				            </span> - <span class="item-location"><i class="fa fa-map-marker"></i>&nbsp;
				            <a href="http://localhost:8000/search?l=1185241" class="info-link">Dhaka</a> 
				            </span>
				        </span>
				      </div>

				      <span class="item-price">
				            ৳ 645
				      </span>&nbsp;&nbsp;
				        <a class="btn btn-default btn-sm make-favorite" id="2"><i class="fa fa-heart"></i><span> Save </span></a>      
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
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">More Description</h4>
        </div>
        <div class="modal-body">
        	<div class="shop-hours">
        		<h3>খোলার সময়</h3>
	        	<p><span class="open-day"> রবিবার: </span> <span class="open-time"> ৯:০০ এএম – ৯:০০ পিএম<span></p>
	        	<p><span class="open-day"> সোমবার:  </span> <span class="open-time"> ৯:০০ এএম – ৯:০০ পিএম</p>
	        	<p><span class="open-day">মঙ্গলবার:  </span> <span class="open-time"> ৯:০০ এএম – ৯:০০ পিএম</p>
	        	<p><span class="open-day">বুধবার:  </span> <span class="open-time"> ৯:০০ এএম – ৯:০০ পিএম</p>
	        	<p><span class="open-day">বুৃহস্পতিবার:  </span> <span class="open-time"> ৯:০০ এএম – ৯:০০ পিএম</p>
	        	<p><span class="open-day"> শুক্রবার: </span> <span class="open-time off">বন্ধ</span></p>
	        	<p><span class="open-day">শনিবার:  </span> <span class="open-time"> ৯:০০ এএম – ৯:০০ পিএম</p>
	        </div><br/>
	        <div class="address">
	        	<h3>Address</h3>
	        	<p>147/C, 4th Floor,Green Road, Dhaka, Bangladesh</p>
	        </div>

	        <div class="description">
	        	<h3>Description</h3>
	        	<p>We, the Pinon Medical Equipments Importer &amp; Supplier of 4D Color Doppler, Digital X-Ray, Color ECG, ETT/EEG, Video Colposcopy &amp; Endoscopy, OT Equipment, Biochemistry Analyzer with Hematology/Electrolyte &amp; Other Hospital Equipment since long with good reputation. We are engaged for the same in some notable Hospital &amp; Clinic for some couple of years.
 
				Hence we are very much interested to establish relationship for providing services to your esteemed organization. So we would seek your kind assistance to give one chance to our company as provider of servicing and maintenance with supply these Instruments.</p>
	        </div>

	        <div class="website">
	        	<h3>আমাদের ওয়েব সাইট ভিজিট করুন</h3>
				<a href="#"> http://www.pinongroup.net </a>
	        </div>
        </div>
      </div>
    </div>
</div>
@endsection