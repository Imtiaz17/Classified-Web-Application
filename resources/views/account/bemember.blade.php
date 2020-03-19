@extends('layouts.master')
@section('after_styles')
<style>
</style>
@endsection
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
									<h4 class="panel-title"><a href="#userPanel" data-toggle="collapse" data-parent="#accordion">Be our member</a></h4>
								</div>

							<div class="panel-collapse collapse {{ (old('panel')=='' or old('panel')=='userPanel') ? 'in' : '' }}" id="userPanel">
								@if(Auth::user()->member_request==1)
								<div class="panel-body" style="padding:40px;">
									<h2 style="color:#2A3744">Member request awaiting for approval ..</h2>
								</div>
								@else
								<div class="panel-body">
									<h3>Want  to be a member??</h3>
									<form class="form-horizontal" role="form" method="post" action="{{route('bemember',Auth::user()->id)}}">
										 {{csrf_field()}}
										{{method_field('PATCH')}}
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="form-check">
										  <input class="form-check-input" type="radio" name="member" id="yeswant" value="yes">
										  <label class="form-check-label" for="yeswant">
										    Yes
										  </label>
										</div>
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="nomember" id="dontwant" value="no">
										  <label class="form-check-label" for="dontwant">
										    No
										  </label>
										</div>
											</div>
										</div>
										<input type="submit" name="" class="btn btn-success btn-md">
									</form>
								</div>
								@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection