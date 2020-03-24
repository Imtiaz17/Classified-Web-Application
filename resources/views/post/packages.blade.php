@extends('layouts.master')
@section('before_styles')
    <style type="text/css">
        .promote-list p {
            color: #707676;
            font-size: 15px;
            margin-bottom: 3px;
            font-weight: 500;
        }
        .promote-list h4 {
            padding-bottom: 3px;
            font-size: 20px;
        }
        .promote-list img {
            height: 45px;
            margin-left: 10px;
        }
        .promote-list {
            border: 1px solid #e6e6e6;
            padding: 10px;
        }
        label {
            cursor: pointer;
            margin: 0px !important;
        }
        .duration-list {
            padding: 5px 12px;
        }
        .box {
            padding-top: 15px;
            margin: 0px -21px 0px 0px
        }
        .price-list {
            display: none;
        }
        .paybleamount
        {
            margin-top: 7px;
            font-size: 21px;
            margin-bottom:0px;
        }
    </style>
    @endsection
@section('wizard')
    @include('post.inc.wizard')
@endsection

@section('content')
    @include('common.spacer')
    <div class="main-container">
        <div class="container">
            <div class="row">
                @include('post.inc.notification')

                <div class="col-md-12 page-content">
                    <div class="inner-box category-content">
                        <h2 class="title-2"><strong> <i class="icon-tag"></i> {{ t('Pricing') }}</strong></h2>
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-horizontal" id="postForm" method="POST"
                                      action="{{ url()->current() }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="totalprice" value="">
                                    
                                    <fieldset>
                                       

                                        @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
                                            <div class="well" style="padding-bottom: 0;">
                                                <h3><i class="icon-certificate icon-color-1"></i> {{ t('Premium Ad') }}
                                                </h3>
                                                <p>
                                                    {{ t('The premium package help sellers to promote their products or services by giving more visibility to their ads to attract more buyers and sell faster.') }}
                                                </p>
                                                <div class="form-group <?php echo (isset($errors) and $errors->has('package')) ? 'has-error' : ''; ?>"
                                                     style="margin-bottom: 0;">
                                                    <table id="packagesTable" class="table table-hover checkboxtable"
                                                           style="margin-bottom: 0;">
                                                           <?php
															// Get Current Payment data
															$currentPaymentMethodId = 0;
															$currentPaymentActive = 1;
															if (isset($currentPayment) and !empty($currentPayment)) {
																$currentPaymentMethodId = $currentPayment->payment_method_id;
																if ($currentPayment->active == 0) {
																	$currentPaymentActive = 0;
																}
															}
														?>
                                                       
                                                        @foreach ($packages as $package)
                                                    
                                                           
                                                            <tr>
                                                                <td>
                                                                    <div class="promote-list">          
                                                                          
                                                                            <label for="{{$package->id}}" class="row" style="width:100%">
                                                                                    <div class="box">
                                                                                        <div class="col-xs-2">
                                                                                        <input type="checkbox" onchange="promoteAd('{{$package->name}}','{{$package->id}}')"  class="check{{$package->name}}"
                                                                                            name="package[{{$package->id}}]" id="{{$package->id}}" value="{{$package->id}}">
                                                                                        <img src="{{asset('uploads/'.$package->picture)}}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-6">
                                                                                    <h4>{{$package->name}}</h4>
                                                                                    <p>{{$package->description}}</p>
                                                                                    <a href="#">Know more</a>
                                                                                </div>
                                                                            </label>
                                                                    
                                                                    <div class="price-list" id="{{$package->name}}">
                                                                        <div class="row ad-durations">
                                                                            @foreach($package->durations as $duration)
                                                                                <div class="duration-list col-xs-12">
                                                                                    <input type="hidden" class="{{$package->name}}"
                                                                                           name="totalday[{{$package->id}}]" value=''>
                                                                                    <input type="radio" name="price[{{$package->id}}]"
                                                                                           value="{{$duration->price}}" data-duration="{{$duration->duration}}"  data-price="{{$duration->price}}"
                                                                                           onchange="selectDay('{{$package->name}}','{{$duration->duration}}','{{$duration->price}}')">
                                                                                        
                                                                                    <span> {{$duration->duration}}</span>
                                        
                                                                                    <span class="price{{$duration->price}}"
                                                                                          style="float: right;"> {{$duration->price}}</span>
                                        
                                                                                </div>
                                        
                                                                            @endforeach
                                                                        </div>
                                                                    </div>

                                                                       
                                                                   
                                                                    </div>
                                                                </td>
                                                                {{--  <td>
                                                                    <p id="price-{{ $package->tid }}">
                                                                        @if ($package->currency->in_left == 1)
                                                                            <span class="price-currency">{{ $package->currency->symbol }}</span>
                                                                        @endif
                                                                        <span class="price-int">{{ $package->price }}</span>
                                                                        @if ($package->currency->in_left == 0)
                                                                            <span class="price-currency">{{ $package->currency->symbol }}</span>
                                                                        @endif
                                                                    </p>
                                                                </td>  --}}
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td>
                                                                <p class="paybleamount">
                                                                    <strong>
                                                                        {{ t('Payable Amount') }} :
                                                                        <span class="price-currency amount-currency currency-in-left"
                                                                              style="display: none;"></span>
                                                                        <span class="payable-amount total">0</span>
                                                                        <span class="price-currency amount-currency currency-in-right"
                                                                              style="display: none;"></span>
                                                                    </strong>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td>
                                                                <div class="form-group <?php echo (isset($errors) and $errors->has('payment_method')) ? 'has-error' : ''; ?>"
                                                                     style="margin-bottom: 0;">
                                                                    <div class="col-md-8">
                                                                        <select style="width: 400px;" class="form-control selecter"
                                                                                name="payment_method"
                                                                                id="payment_method">
                                                                            @foreach ($paymentMethods as $paymentMethod)
                                                                                @if (view()->exists('payment::' . $paymentMethod->name))
                                                                                    <option value="{{ $paymentMethod->id }}"
                                                                                            data-name="{{ $paymentMethod->name }}" {{ (old('payment_method', $currentPaymentMethodId)==$paymentMethod->id) ? 'selected="selected"' : '' }}>
                                                                                        @if ($paymentMethod->name == 'offlinepayment')
                                                                                            Bkash
                                                                                        @else
                                                                                            {{ $paymentMethod->display_name }}
                                                                                        @endif
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <div>
                                                                            <input style="margin-top: 17px; width: 400px;"
                                                                             name="bkash_no"
                                                                            class="form-control"
                                                                            placeholder="Bkash No"
                                                                            type="text"
                                                                            >
                                                                            <input style="margin-top: 17px; width: 400px;"
                                                                            id="price" name="ref_no"
                                                                            class="form-control"
                                                                            placeholder="Transaction Id"
                                                                            type="text"
                                                                            value="{{ old('ref_no') }}">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                           
                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>

                                        @if (isset($paymentMethods) and $paymentMethods->count() > 0)
                                            <!-- Payment Plugins -->
                                            <?php $hasCcBox = 0; ?>
                                            @foreach($paymentMethods as $paymentMethod)
                                                @if (view()->exists('payment::' . $paymentMethod->name))
                                                    @include('payment::' . $paymentMethod->name, [$paymentMethod->name . 'PaymentMethod' => $paymentMethod])
                                                @endif
                                                <?php if ($paymentMethod->has_ccbox == 1 && $hasCcBox == 0) $hasCcBox = 1; ?>
                                            @endforeach
                                        @endif
                                    @endif

                                    <!-- Button  -->
                                        <div class="form-group">
                                            <div class="col-md-12 mt20" style="text-align: center;">
                                                @if (getSegment(2) == 'create')
                                                    <a id="skipBtn"
                                                       href="{{ lurl('posts/create/' . $post->tmp_token . '/finish') }}"
                                                       class="btn btn-default btn-lg">{{ t('Skip') }}</a>
                                                @else
                                                    <a id="skipBtn"
                                                       href="{{ lurl(slugify($post->title) . '/' . $post->id . '.html') }}"
                                                       class="btn btn-default btn-lg">{{ t('Skip') }}</a>
                                                @endif
                                                <button id="submitPostForm"
                                                        class="btn btn-success btn-lg submitPostForm"> {{ t('Pay') }} </button>
                                            </div>
                                        </div>

                                        
                                        <div style="margin-bottom: 30px;"></div>

                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
    @if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
        <script src="{{ url('/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}"
                type="text/javascript"></script>
    @endif

    <script>
        var spotadprice = 0;
        var topadprice = 0;
        var bumpadprice = 0;
        var totalprice = 0;

        function promoteAd(name,id) {
            $('#'+ name).toggle();
            if($('input[type="radio"][name="price['+id+']"]').is(':checked'))
            {
                var price=($('input[type="radio"][name="price['+id+']"]:checked').data('price'));
                $('input[type="radio"][name="price['+id+']"]').prop('checked',false);
                $('input[type="radio"][name="price['+id+']"]').data('waschecked',false);
                totalprice =totalprice-parseInt(price);
                $(".total").html('BDT ' +totalprice);
                $("input[name='totalprice']").val(totalprice);
            }
            else{
               

                $('input[type="radio"][name="price['+id+']"]').prop('checked',true);
                $('input[type="radio"][name="price['+id+']"]').data('waschecked',true);
                var price=($('input[type="radio"][name="price['+id+']"]:checked').data('price'));
                var duration=($('input[type="radio"][name="price['+id+']"]:checked').data('duration'));
                this.selectDay(name,duration,price)
            }
        }
        
        function selectDay(name,duration,price) {
            if (name == 'Spotlight') {
                $(".Spotlight").val(duration)
                spotadprice = $("#Spotlight input[type='radio']:checked").val();
                totalprice = parseInt(spotadprice) + parseInt(topadprice) + parseInt(bumpadprice);
                $(".total").html('BDT ' +totalprice);
                $("input[name='totalprice']").val(totalprice);
        }
        if (name == 'Topad') {
            $(".Topad").val(duration)
            topadprice = $("#Topad input[type='radio']:checked").val();
            totalprice = parseInt(spotadprice) + parseInt(topadprice) + parseInt(bumpadprice);
                $(".total").html('BDT ' +totalprice);
                $("input[name='totalprice']").val(totalprice);
        }
        if (name == 'Bumpad') {
            $(".Bumpad").val(duration)
            bumpadprice = $("#Bumpad input[type='radio']:checked").val();
            totalprice = parseInt(spotadprice) + parseInt(topadprice) + parseInt(bumpadprice);
                $(".total").html('BDT ' +totalprice);
                $("input[name='totalprice']").val(totalprice);
        }
    }


                @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
        $(document).ready(function () {
            $('#submitPostForm').on('click', function (e) {
                e.preventDefault();
                    $('#postForm').submit();
                return false;
            });
        });

        @endif

        /* Show or Hide the Payment Submit Button */
        /* NOTE: Prevent Package's Downgrading */
        /* Hide the 'Skip' button if Package price > 0 */
        
        
    </script>
@endsection
