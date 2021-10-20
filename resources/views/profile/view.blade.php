@extends('layouts.app', ['page' => __('My Profile'), 'pageSlug' => 'profile'])
<?php //echo '<pre>';print_r($admin);echo'</pre>';die;?>
@section('content')
<?php $image_path = config('global.image_path'); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('My Profile') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                        </div>
                    </div>
                </div>
                <div class="row col-md-12">
                    @include('alerts.success')

                    <div class="col-8">
                        <table class="table tablesorter " id="">
                            <tbody>
                                <tr>
                                    <td>Name :</td>
                                    <td> {{ $admin->name }}</td>
								</tr>
                                <tr>
                                    <td>Email :</td>
                                    <td> {{ $admin->email }}</td>
								</tr>
                            </tbody>
                        </table>
                    </div>
					<div class="col-4">
					<table class="table tablesorter " id="">
                            <tbody>
                                <tr>
                                    <td><img src="{{ $image_path  }}{{ auth()->user()->profile_pic ?? 'employee.jpg' }}" /></td>
								</tr>
                            </tbody>
                        </table>
					</div>
                </div>
                <div class="card-footer py-4">

                </div>
            </div>
        </div>
    </div>
@endsection