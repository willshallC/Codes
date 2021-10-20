@extends('employee.layouts.emp-app', ['pageSlug' => 'assigned-projects'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('My Projects') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')
                    <div class="">
						<div class="row">
							<?php
							$product_status = array();
							$product_status[1] = 'Active';
							$product_status[2] = 'Completed';
							$product_status[3] = 'On-Hold';
							$product_status[4] = 'Canceled';
							$product_status[5] = 'Dispute';
							?>
							@foreach ($assignedProjects as $assignedProject)
							<div class="col-6 clearfix" style="margin: 10px 0;">
								<h5 class="card-title" style="font-size: 15px;">Title  : <a href= "{{url('project',$assignedProject->id)}}">{{ $assignedProject->project_title }}</a> </h5>
								Url : <a href= "#">{{ $assignedProject->url }}</a>
								<br> Desciption : {{ $assignedProject->description }}
								<br>Start Date : {{ $assignedProject->start_date }}
								<br>Priority : {{ $assignedProject->priority }}
								<br>Status : {{ $product_status[$assignedProject->status] }}
								<h5> </h5>
							</div>
							
							@endforeach
						 </div>
                    </div>
                </div>
                <div class="card-footer py-4"></div>
            </div>
        </div>
    </div>
@endsection
