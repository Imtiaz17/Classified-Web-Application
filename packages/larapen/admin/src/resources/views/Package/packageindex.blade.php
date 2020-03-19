@extends('admin::layout')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
   {{--  <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endsection

@section('header')
    <section class="content-header">
        <h1>
           List of Packages
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
            <a href="{{route('package.create')}}" class="btn btn-primary ladda-button" data-style="zoom-in">
                <span class="ladda-label">
                    <i class="fa fa-plus"></i> Add Package
                </span>
            </a>
        </div>
        <div class="box-body">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">Package name</th>
                    <th class="text-center">Package picture</th>
                    <th class="text-center">Package details</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>

                @forelse($packages as $package)
                    <tr>
                        <td class="text-center">{{ $package->name }}</td>
                        <td class="text-center"><img src= "{{ asset('uploads/'.$package->picture) }}" width="70px" height="70px" alt="LP"></td> 
                        <td class="text-center">{{ $package->description}}</td>
                        <td class="text-center">
                        <a href="{{route('addtime',$package->name)}}" class="btn btn-xs btn-default"><i class="fa fa-plus"></i>Timelimit</a>
                          <a href="{{ route('package.edit',$package->id) }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</a>
                          <form action="{{route('package.destroy',$package->id)}}" id="delete-form-{{ $package->id }}"
                                  method="post" style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
                              <button onclick="if(confirm('Are you sure to delete this package?')){
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{ $package->id }}').submit();
                                    }else{
                                    event.preventDefault();
                                    }" class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>Delete</button>
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
