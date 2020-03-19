<!-- City -->
<div class="row">
	<div class="col-sm-6">
		<div class="locations-list list-filter">
			<strong><a href="#">All Location</a></strong>
			<ul class="browse-list list-unstyled long-list">
		        @if (isset($cities) and $cities->count() > 0)
					@foreach ($cities as $city)
						<?php
						$fullUrlLocation = lurl(trans('routes.v-search', ['countryCode' => $country->get('icode')]));
						$locationParams = [
							'l'  => $city->id,
							'r'  => '',
							'c'  => (isset($cat)) ? $cat->tid : '',
							'sc' => (isset($subCat)) ? $subCat->tid : '',
						];
						?>
						<li>
							@if ((isset($uriPathCityId) and $uriPathCityId == $city->id) or (Request::input('l')==$city->id))
								<strong>
									<a onclick="getCity('{{$city->id}}')" title="{{ $city->name }}">
										{{ $city->name }}
									</a>
								</strong>
							@else
								<a href="/search?location={{$city->name}}&l={{$city->id}}" title="{{ $city->name }}">
									{{ $city->name }}
								</a>
							@endif
						</li>
					@endforeach
		        @endif
			</ul>
		</div>
	</div>
	<div class="col-sm-6">
		
		<div id="showCity"></div>
	</div>
</div>

<script type="text/javascript">
	function getCity(name){
		document.getElementById('showCity').innerHTML = ' <strong><a href="#">'+ name + ' এর মধ্যে একটি স্থানীয় এলাকা নির্বাচন করুন</a></strong>';
	}
</script>
