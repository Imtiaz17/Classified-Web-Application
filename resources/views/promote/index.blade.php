@extends('layouts.master')

@section('before_styles')
    <style type="text/css">
        #wrapper {
            background: #f8f8f8 !important;
            height: auto !important;
        }

        h4.ads-list {
            border-bottom: 1px solid #e4e4e4;
            margin: 10px 0px;
        }

        .make-list {
            width: 100%;
            clear: both;
            overflow: hidden;
            border: 1px solid #e6e6e6;
            padding:18px;
            border-radius: 4px 4px 0px 0px;
        }
        .topad, .bumpad, .spotlight {
        vertical-align: middle;
        margin: 0px !important;
        padding: 10px 0px;
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

        .ad-durations {
            vertical-align: middle;
            margin: 0px !important;
            border-top: 1px solid #e6e6e6
        }

        .price-section img, .price-list img {
            height: 25px;
            margin-right: 5px
        }

        .price-list {
            display: none;
        }

        .border-left {
            border-left: .5px solid #e0dede;
            padding: 8px 25px !important
        }

        .duration-list {
            padding: 10px 12px;
            border-bottom: 1px solid #d4ded9;
        }

        .promote-list {
            border: 1px solid #e6e6e6;
            margin-bottom: 15px;
        }

        label {
            cursor: pointer;
            padding: 10px 0 !important;
            margin: 0px !important;
        }

        label:hover {
            background: #f3f3f3;
            cursor: pointer;
        }

        .promote-list img {
            height: 45px;
            margin-left: 10px;
        }

        .promote-list h4 {
            padding-bottom: 3px;
            font-size: 15px;
        }

        .promote-list p {
            color: #707676;
            font-size: 12px;
            margin-bottom: 3px;
        }

        .box {
            padding-top: 15px;
            margin: 0px -21px 0px 0px
        }

        .is-hidden {
            display: none;
        }

    </style>
@endsection


@section('content')
    <div class="container" style="background: #fff !important; margin: 15px auto;padding: 20px;">
        <form method="post" action="{{ route('promotion') }}">
            <div class="row">
                <div class="col-md-6">
                    <h3>Selected Ad for promotion</h3>
                    @php
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
                                                class="fa fa-camera"></i>  {{ $pictures->count()}}  </span>
                                    <a href="#">
                                        <img class="thumbnail no-margin" src="{{ $postImg }}" alt="img">
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-9 col-xs-7 add-desc-box">
                                <div class="add-details">
                                    <h5 class="add-title"><a
                                                href="{{ $postUrl }}">{{ mb_ucfirst(str_limit($post->title, 70)) }}</a>
                                    </h5>

                                    <span class="info-row">
				            <span class="date"><i
                                        class="icon-clock"> </i>{{ $post->created_at->diffForHumans()}} </span>
				            @if (isset($liveCatParentId) and isset($liveCatName))
                                            <span class="category">
							- <a href="{!! qsurl(config('app.locale').'/'.trans('routes.v-search', ['countryCode' => $country->get('icode')]), array_merge(Request::except('c'), ['c'=>$liveCatParentId])) !!}"
                                 class="info-link">{{ $liveCatName }}</a>
						</span>
                                        @endif<span class="item-location"><i class="fa fa-map-marker"></i>&nbsp;
				            <a href="http://localhost:8000/search?l=1185241" class="info-link">{{$city->name}}</a> 
				            </span>
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

                    <div class="price-section is-hidden">
                        <div class="row spotlight is-hidden">
                            <div class="col-xs-10">
                                <img src="">
                                <span class="pname"></span><span class="days"></span>
                            </div>
                            <div class="col-xs-2"><span class="price"></span></div>

                        </div>
                        <div class="row topad is-hidden">
                            <div class="col-xs-10">
                                <img src="">
                                <span class="pname"></span><span class="days"></span>
                            </div>
                            <div class="col-xs-2"><span class="price"></span></div>

                        </div>
                        <div class="row bumpad is-hidden">
                            <div class="col-xs-10">
                                <img src="">
                                <span class="pname"></span><span class="days"></span>
                            </div>
                            <div class="col-xs-2"><span class="price"></span></div>

                        </div>
                        <div class="row subtotal is-hidden">
                            <div class="col-md-10">
                                <p class="sum">Total</p>
                            </div>
                            <div class="col-md-2"><span class="total"></span></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 border-left">
                    <div class="promote">
                        <h2>Get more view's to your add</h2>
                        <h3>Select a promotion to get quick sell</h3>
                        <p style="font-size: 16px;">select one or more option's</p>

                    </div>
                     @if ($errors->any())
                      <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                      </div><br />
                    @endif
                    <input type="hidden" name="postid" value="{{$id}}">
                    <input type="hidden" name="totalprice" value="">
                    @foreach($packages as $package)
                        <div class="promote-list">
                            <label for="{{$package->id}}" class="row" >
                                <div class="col-xs-2">
                                    <div class="box">
                                        <input type="checkbox" onchange="promoteAd('{{$package->name}}','{{$package->id}}')" id="{{$package->id}}" class="check{{$package->name}}"
                                               name="package[]" value="{{$package->id}}">
                                        <img src="{{asset('uploads/'.$package->picture)}}">
                                    </div>
                                </div>
                                <div class="col-xs-10">
                                    <h4>{{$package->name}}</h4>
                                    <p>প্রতিদিন নতুনভাবে শুরু করুন এবং ৫ গুণ বেশী ক্রেতার নজরে আসার সুযোগ দিন!</p>
                                    <a href="#"> আরও জানুন </a>
                                </div>
                            </label>
                            <div class="price-list" id="{{$package->name}}">
                                <div class="row ad-durations">
                                    @foreach($package->durations as $duration)
                                        <div class="duration-list col-xs-12">
                                            <input type="hidden" class="{{$package->name}}"
                                                   name="totalday[{{$package->id}}]" value=''>
                                            <input type="radio" name="price[{{$package->id}}]"
                                                   value="{{$duration->price}}"
                                                   onchange="selectDay('{{$package->name}}','{{$package->picture}}','{{$duration->duration}}','{{$duration->price}}')">
                                            <span> {{$duration->duration}}</span>

                                            <span class="price{{$duration->price}}"
                                                  style="float: right;"> {{$duration->price}}</span>

                                        </div>

                                    @endforeach
                                </div>
                            </div>

                        </div>
                    @endforeach

                    <button type="submit" style="width: 100%; margin-top: 5px;" class="btn btn-success">Promote Now
                    </button>

                </div>
            </div>
        </form>
    </div>


@endsection

@section('after_scripts')
    <script>
        var spotadprice = 0;
        var topadprice = 0;
        var bumpadprice = 0;
        var totalprice = 0;
       


        function promoteAd(list,id) {
            $('#'+ list).toggle();
             // $('input[type="radio"][name="price'+id+'"]').prop("checked", true);
        }

        function selectDay(name, pic, duration, price) {

            $(".subtotal").css('display', 'block');
            $(".price-section").css('display', 'block');
            var names = name;
            var img = pic;
            var image_path = "{{asset('uploads/')}}/";

            if (names == 'Spotlight') {
                $(".Spotlight").val(duration)
                spotadprice = $("#Spotlight input[type='radio']:checked").val();
                $(".spotlight").css('display', 'block');
                $(".spotlight img").attr('src', '' + image_path + pic + '');
                $(".spotlight .pname").html(name + ' for ');
                $(".spotlight .days").html(duration + ' days ');
                $(".spotlight .price").html('BDT ' + price);
                totalprice = parseInt(spotadprice) + parseInt(topadprice) + parseInt(bumpadprice);
                $(".total").html('BDT ' +totalprice);
                $("input[name='totalprice']").val(totalprice);
            }
            if (names == 'Topad') {
                $(".Topad").val(duration)
                topadprice = $("#Topad input[type='radio']:checked").val();
                $(".topad").css('display', 'block');
                $(".topad img").attr('src', '' + image_path + pic + '');
                $(".topad .pname").html(name + ' for ');
                $(".topad .days").html(duration + ' days ');
                $(".topad .price").html('BDT ' + price);
                totalprice = parseInt(spotadprice) + parseInt(topadprice) + parseInt(bumpadprice);
                $(".total").html('BDT ' +totalprice);
                $("input[name='totalprice']").val(totalprice);
            }
            if (names == 'Bumpad') {
                $(".Bumpad").val(duration)
                bumpadprice = $("#Bumpad input[type='radio']:checked").val();
                $(".bumpad").css('display', 'block');
                $(".bumpad img").attr('src', '' + image_path + pic + '');
                $(".bumpad .pname").html(name + ' for ');
                $(".bumpad .days").html(duration + ' days ');
                $(".bumpad .price").html('BDT ' + price);
                totalprice = parseInt(spotadprice) + parseInt(topadprice) + parseInt(bumpadprice);
                $(".total").html('BDT ' +totalprice);
                $("input[name='totalprice']").val(totalprice);
            }

            // $(".topad").append('<div class="col-xs-10"><img src="'+image_path+pic+'"><span>'+name+' for '+duration+' days </span></div><div class="col-xs-2"><span>'+price+'</span></div>')
            // $(".price-section ."+type+ " .day").html( day);
            // $(".price-section ."+type+ " .price").html( price);
        }


    </script>
@endsection