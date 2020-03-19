<style type="text/css">
	.make-list{position: relative; margin-top: 10px;}
	.ads-icon{ position: absolute;right: 10px; bottom: 5px;font-size: 12px;font-weight: bold;}
	.topads {border: 1px solid #ffcb5f !important; border-radius: 3px;  background-color: rgba(255,203,95,.05); padding: 5px !important;}
</style>
<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.app_cache_expiration');
}
?>
@if (isset($topad))
	<?php
		if (!isset($cats)) {
			$cats = collect([]);
		}
  
		foreach($topad as $key => $post):
		if (empty($countries) or !$countries->has($post->country_code)) continue;
		// Get Pack Info
	 	
		// Get PostType Info
		$cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
    	$postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
            $postType = \App\Models\PostType::transById($post->post_type_id);
			return $postType;
		});
		if (empty($postType)) continue;
	
		// Get Post's URL
		$postUrl = lurl(slugify($post->title) . '/' . $post->id . '.html');
  
		// Get Post's Pictures
		$pictures = \App\Models\Picture::where('post_id', $post->id)->orderBy('position')->orderBy('id');
		if ($pictures->count() > 0) {
			$postImg = resize($pictures->first()->filename, 'medium');
		} else {
			$postImg = resize(config('larapen.core.picture.default'));
		}
  
		// Get the Post's City
		$cacheId = config('country.code') . '.city.' . $post->city_id;
    	$city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
            $city = \App\Models\City::find($post->city_id);
			return $city;
		});
		if (empty($city)) continue;
	?>

		{{-- expr --}}
	<div class="make-list promote topads" style="width: 100%;clear: both;overflow: hidden;border-bottom: 1px solid #dcddda;padding: 8px 0px;">
		
		<div class="col-sm-3 col-xs-5 no-padding photobox">
			<div class="add-image">
				<span class="photo-count"><i class="fa fa-camera"></i> {{ $pictures->count() }} </span>
				<a href="{{ $postUrl }}">
					<img class="thumbnail no-margin" src="{{ $postImg }}" alt="img">
				</a>
			</div>
		</div>	
		<div class="col-sm-9 col-xs-7 add-desc-box">
			<div class="add-details">
				<h5 class="add-title"><a href="{{ $postUrl }}">{{ mb_ucfirst(str_limit($post->title, 70)) }} </a></h5>
				
				<span class="info-row">
					<span class="add-type business-ads tooltipHere" data-toggle="tooltip" data-placement="right" title="{{ $postType->name }}">
						{{ strtoupper(mb_substr($postType->name, 0, 1)) }}
					</span>&nbsp;
					<?php
						// Convert the created_at date to Carbon object
						
						// Category
						$cacheId = 'category.' . $post->category_id . '.' . config('app.locale');
                    	$liveCat = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                            $liveCat = \App\Models\Category::find($post->category_id);
							return $liveCat;
						});

						// Check parent
						if (empty($liveCat->parent_id)) {
							$liveCatParentId = $liveCat->id;
							$liveCatType = $liveCat->type;
						} else {
							$liveCatParentId = $liveCat->parent_id;
							
                            $cacheId = 'category.' . $liveCat->parent_id . '.' . config('app.locale');
                            $liveParentCat = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($liveCat) {
                                $liveParentCat = \App\Models\Category::find($liveCat->parent_id);
                                return $liveParentCat;
                            });
							$liveCatType = (!empty($liveParentCat)) ? $liveParentCat->type : 'classified';
						}

						// Check translation
						if ($cats->has($liveCatParentId)) {
							$liveCatName = $cats->get($liveCatParentId)->name;
						} else {
							$liveCatName = $liveCat->name;
						}
					?>
					<span class="date"><i class="icon-clock"> </i> {{ $post->created_at->diffForHumans() }} </span>
					@if (isset($liveCatParentId) and isset($liveCatName))
						<span class="category">
							- <a href="{!! qsurl(config('app.locale').'/'.trans('routes.v-search', ['countryCode' => $country->get('icode')]), array_merge(Request::except('c'), ['c'=>$liveCatParentId])) !!}" class="info-link">{{ $liveCatName }}</a>
						</span>
					@endif
					- <span class="item-location"><i class="fa fa-map-marker"></i>&nbsp;
						<a href="{!! qsurl(config('app.locale').'/'.trans('routes.v-search', ['countryCode' => $country->get('icode')]), array_merge(Request::except(['l', 'location']), ['l'=>$post->city_id])) !!}" class="info-link">{{ $city->name }}</a> {{ (isset($post->distance)) ? '- ' . round(lengthPrecision($post->distance), 2) . unitOfLength() : '' }}
					  </span>
				</span>
			</div><br/>

			<span class="item-price">
				@if (isset($liveCatType) and !in_array($liveCatType, ['not-salable']))
					@if ($post->price > 0)
						{!! \App\Helpers\Number::money($post->price) !!}
					@else
						{!! \App\Helpers\Number::money('--') !!}
					@endif
				@else
					{{ '--' }}
				@endif
			</span>
           {{--  @if (!empty($bumpad))
               
                    <a class="btn btn-danger btn-sm make-favorite"><i class="fa fa-certificate"></i><span>Bumpadd</span></a>&nbsp;
               
            @endif --}}
			@if (Auth::check())
				<a class="btn btn-{{ (\App\Models\SavedPost::where('user_id', $user->id)->where('post_id', $post->id)->count() > 0) ? 'success' : 'default' }} btn-sm make-favorite"
				   id="{{ $post->id }}">
					<i class="fa fa-heart"></i><span> {{ t('Save') }} </span>
				</a>
			@else
				<a class="btn btn-default btn-sm make-favorite" id="{{ $post->id }}"><i class="fa fa-heart"></i><span> {{ t('Save') }} </span></a>
			@endif

			@if (isset($reviewsPlugin) and !empty($reviewsPlugin))
				@if (view()->exists('reviews::ratings-list'))
					@include('reviews::ratings-list')
				@endif
			@endif

			
		</div>
	
		<div class="ads-icon" >
			<a href="#"><img width="25" src="{{asset('images/topad.png')}}"> TOP AD</a>
		</div>
		
		
	</div>
		
	<?php endforeach; ?>
@else
@endif
