@extends('layouts.master')

@section('before_styles')
    <style type="text/css">
        .make-list {
            width: 100%;
            clear: both;
            overflow: hidden;
            border: 1px solid #e6e6e6;
            padding:18px;
            border-radius: 4px 4px 0px 0px;
        }
        .packagelist {
        vertical-align: middle;
        margin: 0px !important;
        padding: 6px 0px;
        border-top: 0px;
        }
        .subtotal
        {
            padding-top: 14px;
            padding-bottom: 0px;
            margin: 0px !important;
            background-color: #f3f6f5;
            border-radius: 0 0 4px 4px;
        }

        .price-section {
        border: 1px solid #e6e6e6;
        border-top: 0px;
        border-radius: 0 0 4px 4px;
        }

        .price-section img, .price-list img {
            height: 25px;
            margin-right: 5px
        }
        .bkashform
        {
            border: 1px solid #e6e6e6;
            padding: 10px;
            margin-top: 37px;
            border-radius: 4px;
        }
    </style>
@endsection

@section('content')

    <div class="container" style="background: #fff !important; margin: 15px auto;padding: 20px;">
        <div class="row">
            <div class="col-md-6">
                <h4>Selected Ad for promotion</h4>
                @php
                 if(!session()->has('promotion'))
                 {
				  return Redirect::to('/')->send();
				}
				
                    $postUrl = lurl(slugify($post->title) . '/' . $post->id . '.html');

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
                    $catcacheId = 'category.' . $post->category_id . '.' . config('app.locale');
                    $liveCat = \Illuminate\Support\Facades\Cache::remember($catcacheId, $cacheExpiration, function () use ($post) {
                        $liveCat = \App\Models\Category::find($post->category_id);
                        return $liveCat;
                    });

                    // Check parent
                    if (empty($liveCat->parent_id)) {
                        $liveCatParentId = $liveCat->id;
                        $liveCatType = $liveCat->type;
                    } else {
                        $liveCatParentId = $liveCat->parent_id;

                        $catcacheId = 'category.' . $liveCat->parent_id . '.' . config('app.locale');
                        $liveParentCat = \Illuminate\Support\Facades\Cache::remember($catcacheId, $cacheExpiration, function () use ($liveCat) {
                            $liveParentCat = \App\Models\Category::find($liveCat->parent_id);
                            return $liveParentCat;
                        });
                        $liveCatType = (!empty($liveParentCat)) ? $liveParentCat->type : 'classified';
                    }

                        $liveCatName = $liveCat->name;

                @endphp
                <div class="make-list">
                    <div class="row">
                        <div class="col-sm-3 col-xs-5 photobox">
                            <div class="add-image">
                                <span class="photo-count"><i
                                            class="fa fa-camera"></i>  {{ $pictures->count() }}  </span>
                                <a href="#">
                                    <img class="thumbnail no-margin" src="{{ $postImg }}" alt="img">
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-9 col-xs-7 add-desc-box">
                            <div class="add-details">
                                <h5 class="add-title"><a
                                            href="{{ $postUrl }}">{{ mb_ucfirst(str_limit($post->title, 70)) }}</a></h5>

                                <span class="info-row">
				        	<span class="item-location"><i class="fa fa-map-marker"></i>&nbsp;
				            <a href="http://localhost:8000/search?l=1185241" class="info-link">{{$city->name}}</a>
				            </span>
				          {{--   <span class="date"><i class="icon-clock"> </i>{{ $post->created_at->diffForHumans()}} </span> --}}
                                    @if (isset($liveCatParentId) and isset($liveCatName))
                                        <span class="category">
							- <a href="{!! qsurl(config('app.locale').'/'.trans('routes.v-search', ['countryCode' => $country->get('icode')]), array_merge(Request::except('c'), ['c'=>$liveCatParentId])) !!}"
                                 class="info-link">{{ $liveCatName }}</a>
						</span>
                                    @endif
				        </span>
                            </div>

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
                    <div class="price-section">
                        @foreach ($promotions as $promotion)
                            @php
                                $package=\App\Models\BPackage::find($promotion->package_id);

                            @endphp

                            <div class="row packagelist">
                                <div class="col-xs-10">
                                    <img src="/uploads/{{$package->picture}}">
                                    <span class="pname">{{$package->name}} for </span>
                                    <span class="adays">{{$promotion->day}} days</span>
                                </div>
                                <div class="col-xs-2"><span class="price">
						BDT {{$promotion->price}}
					</span></div>

                            </div>
                        @endforeach
                    
                    <div class="row subtotal">
                        <div class="col-xs-10">
                            <p class="sum">Total</p>
                        </div>
                        <div class="col-xs-2"><span class="total">BDT {{$totalprice}}</span></div>
                    </div>
                    </div>
                

            </div>
            <div class="col-md-6">
              <form method="post" action="{{ route('storebkashpayment') }}" class="bkashform">
             <p style="font-size: 15px;">Please send BDT <b>{{$totalprice}}</b> to <b>01301253034</b> and then fill up the form</p>
             <div class="form-group">
             <input type="text" name="bkashnumber" class="form-control" placeholder="Your bkash number">
         	</div>
         <div class="form-group">
             <input type="text" name="transactionid" class="form-control" placeholder="bkash transection id">
         </div>
          <div class="form-group row">
          	<div class="col-sm-3">
          		<input type="submit" class="btn btn-success" value="Submit">
          	</div>
          </div>
      </form>
            </div>
        </div>
    </div>
@endsection
