<?php
use Illuminate\Support\Facades\Input;
// Keywords
$keywords = rawurldecode(Input::get('q'));
// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : Input::get('c');
// Location
if (isset($city) and !empty($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
	$qAdmin = Input::get('r');
} else {
	$qLocationId = Input::get('l');
	$qLocation = (Input::filled('r')) ? t('area:') . rawurldecode(Input::get('r')) : Input::get('location');
    $qAdmin = Input::get('r');
}
?>
<div class="container">
	<div class="search-row-wrapper" style="padding: 0;">
		<div class="row" style="background: #f0f0f0;padding: 8px;">
			<form id="seach" name="search" action="{{ lurl(trans('routes.v-search', ['countryCode' => $country->get('icode')])) }}" method="GET">
				
				<div class="col-xs-6 col-sm-2" style="padding-left: 1px; padding-right: 1px;">
					<button type="button" style="background: #f0f0f0" class="btn btn-defualt btn-sm" data-toggle="modal" data-target="#Category">Select Category</button>
				</div>
				<div class="col-xs-6 col-sm-2 search-col locationicon" style="padding-left: 1px; padding-right: 1px;">
					<button type="button" style="background: #f0f0f0" class="btn btn-defualt btn-sm" data-toggle="modal" data-target="#caties">Select city</button>

				</div>
				<div class="col-xs-10 col-sm-7" style="padding-left: 1px; padding-right: 1px;">
					<input name="q" class="form-control keyword" type="text" placeholder="{{ t('What?') }}" value="{{ $keywords }}">
				</div>

				<input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
				<input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">

				<div class="col-xs-2 col-sm-1" style="padding-left: 1px; padding-right: 1px;">
					<button class="btn btn-block btn-primary"><i class="fa fa-search"></i></button>
				</div>
				{!! csrf_field() !!}
			</form>
		</div>
	</div>
	<!-- /.search-row  width: 24.6%;-->
</div>