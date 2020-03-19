@extends('admin::layout')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
   {{--  <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endsection

@section('header')
    <section class="content-header">
        <h1>
           List of Requested Promotion
        </h1>
        <ol class="breadcrumb">
           {{--  <li><a href="{{ url(config('larapen.admin.route_prefix', 'admin').'/dashboard') }}">Admin</a></li>
            <li class="active">Store request </li> --}}
        </ol>
    </section>
@endsection
@section('content')
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            @if (Session::has('flash_notification'))
                    <div class="container" style="margin-bottom: -10px; margin-top: -10px;">
                        <div class="row">
                            <div class="col-lg-12">
                                @include('flash::message')
                            </div>
                        </div>
                    </div>
                @endif
        </div>
        <div class="box-body">
            
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">Post ID</th>
                    <th class="text-center">Package name</th>
                    <th class="text-center">Duration</th>
                    <th class="text-center">Package price</th>
                    <th class="text-center">Total price</th>
                    <th class="text-center">Bkash Number</th>
                    <th class="text-center">Bkash Transaction Id</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Request date</th>
                </tr>
                </thead>
                <tbody>
                @forelse($promotions as $promotion)
                @php
                    $package = \App\Models\BPackage::find($promotion->package_name);   
                    $post = \App\Models\Post::find($promotion->post_id);   
                @endphp
                    <tr>
                        <td class="text-center">
                            <a href="{{lurl(slugify($post->title) . '/' . $post->id . '.html')}}" target="_blank">{{$post->uniq_id}}</a>
                            </td>
                        <td class="text-center">{{$package->name}}</td>
                        <td class="text-center">{{$promotion->duration}}</td>
                        <td class="text-center">{{$promotion->duration_price}}</td>
                        <td class="text-center">{{$promotion->total_price}}</td>
                        <td class="text-center">{{$promotion->bkash_number}}</td>
                        <td class="text-center">{{$promotion->transaction_id}}</td>
                        <td class="text-center">{{$promotion->status}}</td>
                        <td class="text-center">{{$promotion->created_at}}</td>
                        <td class="text-center">
                        
                         
                          <form action="{{route('requestedpromotion.update',$promotion->id)}}" id="update-form-{{ $promotion->id }}"
                                  method="post" style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <input type="hidden" name="promoid" value="{{$promotion->id}}">
                                <input type="hidden" name="package" value="{{$package->name}}">
                            </form>
                            <button onclick="if(confirm('Are you sure to delete this package?')){
                                    event.preventDefault();
                                    document.getElementById('update-form-{{ $promotion->id }}').submit();
                                    }else{
                                    event.preventDefault();
                                    }" class="btn btn-xs btn-default"><i class="fa fa-trash" aria-hidden="true"></i>Accept</button>

                            <form action="{{route('requestedpromotion.update',$promotion->id)}}" id="delete-form-{{ $promotion->id }}"
                                  method="post" style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
                              <button onclick="if(confirm('Are you sure to delete this package?')){
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{ $promotion->id }}').submit();
                                    }else{
                                    event.preventDefault();
                                    }" class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>Decline</button>
                                </td>
                            </tr>
                            @empty
                           <tr>
                            <td>No data</td>
                           </tr>
                          
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
    @endsection
