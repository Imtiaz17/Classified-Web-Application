@extends('admin::layout')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
   {{--  <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endsection

@section('header')
    <section class="content-header">
        <h1>
           List of All Stores
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
        <div class="box-body">
          <table class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th class="text-center">Store name</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Store</th>
                    <th class="text-center">Store id</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($stores as $store)
                    <tr>
                        <td class="text-center">{{ $store->store_name }}</td>
                        <td class="text-center">{{ $store->address }}</td>
                        <td class="text-center">{{ $store->phone }}</td>
                        <td class="text-center">{{ $store->email }}</td>
                        <td class="text-center"><a href="{{lurl('users/' . $store->user_id . '/ads')}}" target="_blank">Go To store</a></td>
                        <td class="text-center">{{ $store->store_id }}</td>
                        <td class="text-center">{{ $store->created_at->format('d-m-Y')}}</td>
                        <td class="text-center">
                          {{--  <form action="{{route('acceptstore',$user->id)}}" id="accept-form-{{ $user->id }}"
                                  method="post" style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                            </form>
                            <form action="{{route('declinestore',$user->id)}}" id="decline-form-{{ $user->id }}"
                                  method="post" style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                            </form>
                            <button onclick="if(confirm('Are you Sure, You went to accept this?')){
                                    event.preventDefault();
                                    document.getElementById('accept-form-{{ $user->id }}').submit();
                                    }else{
                                    event.preventDefault();
                                    }" class="btn btn-xs btn-success">Accept</button>
                             <button onclick="if(confirm('Are you Sure, You went to decline this?')){
                                    event.preventDefault();
                                    document.getElementById('decline-form-{{ $user->id }}').submit();
                                    }else{
                                    event.preventDefault();
                                    }" class="btn btn-xs btn-danger">Decline</button> --}}

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

        </div>
      </div>
      @endsection
