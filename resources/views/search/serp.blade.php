
<?php
	$fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
	$tmpExplode = explode('?', $fullUrl);
	$fullUrlNoParams = current($tmpExplode);
?>
@extends('layouts.master')

@section('search')
	@parent
	@include('search.inc.form')
@endsection

@section('content')
<style type="text/css">
	.carosal-link
	{
		color:#fff;
	}
	.modal-body{
		height: 500px;
		overflow-y: scroll;
	}
	.modal-body ul li{
		padding: 5px 7px;
		border-bottom: 1px solid #efefef;
	}
	.modal-body ul li:hover{
		background: #f5f5f5;
	}
	.modal-body ul li a:after{
		content: "\E83C";
		font-family: fontello;
		position: absolute;
		right:0px;
	}
  #sticky {  position: sticky;
    position: -webkit-sticky;
    top: 83px; }

</style>

	<div class="main-container">		
		@include('search.inc.breadcrumbs')
		<!-- @include('search.inc.categories') -->
		<?php if (\App\Models\Advertising::where('slug', 'top')->count() > 0): ?>
			@include('layouts.inc.advertising.top', ['paddingTopExists' => true])
		<?php

			$paddingTopExists = false;
		else:
			if (isset($paddingTopExists) and $paddingTopExists) {
				$paddingTopExists = false;
			}
		endif;
		?>
		
		<div class="container">
			<div class="row">

				<!-- Sidebar -->
                @if (config('settings.serp_left_sidebar'))
                    @include('search.inc.sidebar')
                    <?php $contentColSm = 'col-sm-6'; ?>
                @else
                    <?php $contentColSm = 'col-sm-12'; ?>
                @endif

				<!-- Content -->
				<div class="{{ $contentColSm }} page-content col-thin-left">
					<div class="category-list">
						<div class="tab-box">

							<!-- Nav tabs -->
							<ul id="postType" class="nav nav-tabs add-tabs" role="tablist">
                                <?php
                                $liClass = '';
                                $spanClass = 'alert-danger';
                                if (!Request::filled('type') or Request::get('type') == '') {
                                    $liClass = 'class="active"';
                                    $spanClass = 'progress-bar-danger';
                                }
                                ?>
								<li {!! $liClass !!}>
									<a href="{!! qsurl($fullUrlNoParams, Request::except(['page', 'type'])) !!}" role="tab" data-toggle="tab">
										{{ t('All Ads') }} <span class="badge {!! $spanClass !!}">{{ $count->get('all') }}</span>
									</a>
								</li>
                                @if (!empty($postTypes))
                                    @foreach ($postTypes as $postType)
                                        <?php
                                            $postTypeUrl = qsurl($fullUrlNoParams, array_merge(Request::except(['page']), ['type' => $postType->tid]));
                                            $postTypeCount = ($count->has($postType->tid)) ? $count->get($postType->tid) : 0;
                                        ?>
                                        @if (Request::filled('type') && Request::get('type') == $postType->tid)
                                            <li class="active">
                                                <a href="{!! $postTypeUrl !!}" role="tab" data-toggle="tab">
                                                    {{ $postType->name }}
                                                    <span class="badge progress-bar-danger">
                                                        {{ $postTypeCount }}
                                                    </span>
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{!! $postTypeUrl !!}" role="tab" data-toggle="tab">
                                                    {{ $postType->name }}
                                                    <span class="badge alert-danger">
                                                        {{ $postTypeCount }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
							</ul>
							<div class="tab-filter">
								<select id="orderBy" class="selecter" data-style="btn-select" data-width="auto">
									<option value="{!! qsurl($fullUrlNoParams, Request::except(['orderBy', 'distance'])) !!}">{{ t('Sort by') }}</option>
									<option{{ (Request::get('orderBy')=='priceAsc') ? ' selected="selected"' : '' }} value="{!! qsurl($fullUrlNoParams, array_merge(Request::except('orderBy'), ['orderBy'=>'priceAsc'])) !!}">{{ t('Price : Low to High') }}</option>
									<option{{ (Request::get('orderBy')=='priceDesc') ? ' selected="selected"' : '' }} value="{!! qsurl($fullUrlNoParams, array_merge(Request::except('orderBy'), ['orderBy'=>'priceDesc'])) !!}">{{ t('Price : High to Low') }}</option>
									<option{{ (Request::get('orderBy')=='relevance') ? ' selected="selected"' : '' }} value="{!! qsurl($fullUrlNoParams, array_merge(Request::except('orderBy'), ['orderBy'=>'relevance'])) !!}">{{ t('Relevance') }}</option>
									<option{{ (Request::get('orderBy')=='date') ? ' selected="selected"' : '' }} value="{!! qsurl($fullUrlNoParams, array_merge(Request::except('orderBy'), ['orderBy'=>'date'])) !!}">{{ t('Date') }}</option>
									@if (isset($isCitySearch) and $isCitySearch)
										<option{{ (Request::get('distance')==100) ? ' selected="selected"' : '' }} value="{!! qsurl($fullUrlNoParams, array_merge(Request::except('distance'), ['distance'=>100])) !!}">{{ t('Around :distance :unit', ['distance' => 100, 'unit' => unitOfLength()]) }}</option>
										<option{{ (Request::get('distance')==300) ? ' selected="selected"' : '' }} value="{!! qsurl($fullUrlNoParams, array_merge(Request::except('distance'), ['distance'=>300])) !!}">{{ t('Around :distance :unit', ['distance' => 300, 'unit' => unitOfLength()]) }}</option>
										<option{{ (Request::get('distance')==500) ? ' selected="selected"' : '' }} value="{!! qsurl($fullUrlNoParams, array_merge(Request::except('distance'), ['distance'=>500])) !!}">{{ t('Around :distance :unit', ['distance' => 500, 'unit' => unitOfLength()]) }}</option>
									@endif
								</select>
							</div>

						</div>

						<!-- <div class="listing-filter hidden-xs">
							<div class="pull-left col-sm-10 col-xs-12">
								<div class="breadcrumb-list text-center-xs">
									{!! (isset($htmlTitle)) ? $htmlTitle : '' !!}
								</div>
                                <div style="clear:both;"></div>
							</div>
                            
							@if ($posts->getCollection()->count() > 0)
								 <div class="pull-right col-xs-2 text-right listing-view-action">
									<span class="list-view"><i class="icon-th"></i></span>
									<span class="compact-view"><i class="icon-th-list"></i></span>
									<span class="grid-view active"><i class="icon-th-large"></i></span>
								</div> 
							@endif

							<div style="clear:both"></div>
						</div>
 						-->
						<div class="adds-wrapper{{ ($contentColSm == 'col-sm-12') ? ' noSideBar' : '' }}">
						@php
							$spotlightpost=\App\Models\Post::where('featured',1)->where('spotlight','1')->get();
						@endphp

						<!-- carousel start -->		
						
							<div id="myCarousel" style="overflow: hidden;margin-top: 5px;" class="carousel slide" data-ride="carousel">
							
								{{-- expr --}}
							
							    <!-- Wrapper for slides -->
							    <div class="carousel-inner">
							    	@foreach ($spotlightpost as $key=>$post)
							    	@php
							    	$cacheId = config('country.code') . '.city.' . $post->city_id;
								    	$city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
								            $city = \App\Models\City::find($post->city_id);
											return $city;
										});
										if (empty($city)) continue;	
										$pictures = \App\Models\Picture::where('post_id', $post->id)->orderBy('position')->orderBy('id');
									if ($pictures->count() > 0) {
										$postImg = resize($pictures->first()->filename, 'medium');
									} else {
										$postImg = resize(config('larapen.core.picture.default'));
									}
							    	@endphp								    	
							       <div class="item {{$key==0 ? 'active' : ''}}">
							        <img src="{{ $postImg }}" alt="{{ $postImg }}" style="width:100%;">
							        <div class="carousel-caption">
								        <div class="add-details">
										    <span class="item-location"><i class="fa fa-map-marker"></i>&nbsp; 
										    	<a href="{!! qsurl(config('app.locale').'/'.trans('routes.v-search', ['countryCode' => $country->get('icode')]), array_merge(Request::except(['l', 'location']), ['l'=>$post->city_id])) !!}"  class="carosal-link">{{ $city->name }}</a>
										    	 </span>
										    <h5 class="add-title"><a href="{{slugify($post->title).'/'.$post->id.'.html'}}" style="color: #fde326" >{{$post->title}}</a></h5>  
										    <span class="item-price">
										    	@if ($post->price > 0)
												{!! \App\Helpers\Number::money($post->price) !!}
												@else
													{!! \App\Helpers\Number::money('--') !!}
												@endif
										    </span>
										</div>
							        </div>

							      </div>
							       @endforeach
							  </div>
							 
							 
							    <!-- Left and right controls -->
							    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
							      <span class="glyphicon glyphicon-chevron-left"></span>
							      <span class="sr-only">Previous</span>
							    </a>
							    <a class="right carousel-control" href="#myCarousel" data-slide="next">
							      <span class="glyphicon glyphicon-chevron-right"></span>
							      <span class="sr-only">Next</span>
							    </a>
							    
							</div>
							<!-- carousel start -->	
							@include('search.inc.topadposts')
							@include('search.inc.posts')
							
						</div>

						<div class="tab-box save-search-bar text-center">
							@if (Request::filled('q') and Request::get('q') != '' and $count->get('all') > 0)
								<a name="{!! qsurl($fullUrlNoParams, Request::except(['_token', 'location'])) !!}" id="saveSearch"
								   count="{{ $count->get('all') }}">
									<i class="icon-star-empty"></i> {{ t('Save Search') }}
								</a>
							@else
								<a href="#"> &nbsp; </a>
							@endif
						</div>
					</div>

					<div class="pagination-bar text-center">
						{!! $posts->appends(Request::except('page'))->render() !!}
					</div>

					<div class="post-promo text-center" style="margin-bottom: 30px;">
						<h2> {{ t('Do you get anything for sell ?') }} </h2>
						<h5>{{ t('Sell your products and services online FOR FREE. It\'s easier than you think !') }}</h5>
						@if (!\Auth::check() and config('settings.guests_can_post_ads') != '1')
							<a href="#quickLogin" class="btn btn-lg btn-border btn-post btn-danger" data-toggle="modal">{{ t('Start Now!') }}</a>
						@else
							<a href="{{ lurl('posts/create') }}" class="btn btn-lg btn-border btn-post btn-danger">{{ t('Start Now!') }}</a>
						@endif
					</div>

				</div>

				<div class="col-sm-3" id="sticky">
					<aside>
					<img src="{{asset('images/ads.jpg')}}">
					</aside>
				</div>
				
				<div style="clear:both;"></div>

				<!-- Advertising -->
				@include('layouts.inc.advertising.bottom')

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
          <h4 class="modal-title">Select Category</h4>
        </div>
        <div class="modal-body">
           @include('search.inc.categories')
        </div>
        
      </div>
    </div>
</div>

<!-- city modal -->
<div class="modal fade" id="caties" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="icon-map"></i> Select Location</h4>
        </div>
        <div class="modal-body">
           @include('search.inc.caties')
        </div>
        
      </div>
    </div>
</div>


@endsection

@section('modal_location')
	@include('layouts.inc.modal.location')
@endsection

@section('after_scripts')
	<script>
		$('.carousel').carousel({
  interval: 5000
})
		/* Default view (See in /js/script.js) */
		@if ($count->get('all') > 0)
			@if (config('settings.serp_display_mode') == '.grid-view')
				gridView('.grid-view');
        	@elseif (config('settings.serp_display_mode') == '.list-view')
        		listView('.list-view');
        	@elseif (config('settings.serp_display_mode') == '.compact-view')
        		compactView('.compact-view');
        	@else
        		gridView('.list-view');
        	@endif
		@else
    		listView('.list-view');
		@endif
		/* Save the Search page display mode */
        var searchDisplayMode = readCookie('searchDisplayModeCookie');
        if (!searchDisplayMode) {
            createCookie('searchDisplayModeCookie', '{{ config('settings.serp_display_mode', '.list-view') }}', 7);
        }
		
		/* Favorites Translation */
        var lang = {
            labelSavePostSave: "{!! t('Save ad') !!}",
            labelSavePostRemove: "{!! t('Remove favorite') !!}",
            loginToSavePost: "{!! t('Please log in to save the Ads.') !!}",
            loginToSaveSearch: "{!! t('Please log in to save your search.') !!}",
            confirmationSavePost: "{!! t('Post saved in favorites successfully !') !!}",
            confirmationRemoveSavePost: "{!! t('Post deleted from favorites successfully !') !!}",
            confirmationSaveSearch: "{!! t('Search saved successfully !') !!}",
            confirmationRemoveSaveSearch: "{!! t('Search deleted successfully !') !!}"
        };
		
		$(document).ready(function () {
			$('#postType a').click(function (e) {
				e.preventDefault();
				var goToUrl = $(this).attr('href');
				redirect(goToUrl);
			});
			$('#orderBy').change(function () {
				var goToUrl = $(this).val();
				redirect(goToUrl);
			});
		});


	</script>
@endsection
