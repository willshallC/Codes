@extends('employee.layouts.emp-app', ['pageSlug' => 'assigned-projects'])

@section('content')
	<?php
		$product_status = array();
		$product_status[1] = 'Active';
		$product_status[2] = 'Completed';
		$product_status[3] = 'Paused';
		$product_status[4] = 'Canceled';
		$product_status[5] = 'Dispute';
	?> 
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
              
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('My Projects') }}</h4>
                        </div>
                    </div>
              
				@include('alerts.success')
               
            </div>
        </div>
    </div>

 <div class=" short-filt">

<div class="short-by-filter">
<ul>

<li><strong>Sort By:</strong>  From</li>
<li class="date-picker"><input type="date" id="min-date" name="bday"></li>
<li>To</li>
<li class="date-picker"><input type="date" id="max-date" name="bday"></li>
<li><a href="javascript:void(0);" class="click-forword"><img src="{{ URL::asset('custom/images/forword-arrow.svg') }}" id="dateRangeSubmit" alt=""></a></li>

</ul>

</div>
</div>


<div class="table-res-mobile status_11">
	<table class="table table-striped table-bordered table-hover project_users-1" id="user-project-list">
		<thead>
			<tr>
				<th>Name</th>
				<th>Start Date</th>
				<th>Department</th>
				<th class="text-center">Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($assignedProjects as $assignedProject)
		<tr>
			<td><a href="{{ route('project',$assignedProject->id) }}">{{ $assignedProject->project_title }}</a></td>
			<td>{{ \Carbon\Carbon::parse($assignedProject->start_date)->format('d-m-Y')}}</td>
			<td>{{ $assignedProject->department }}</td>
			<td class="st-{{ $product_status[$assignedProject->status] }}">{{ $product_status[$assignedProject->status] }}</td>
			<td><a class="all_icons" href="{{url('project',$assignedProject->id)}}"><img src="{{ asset('/') }}custom/images/view-icon.svg" title="View Detail"></a> </td>
		</tr>
		@endforeach
		
		</tbody>
	</table> 
	</div>
@endsection

@push('js')
<script src="{{{ URL::asset('datatable/datatables.min.js')}}}"></script>
<script type="text/javascript">
    var table = jQuery('#user-project-list').DataTable({});

    // Extend dataTables search
	$.fn.dataTable.ext.search.push(
	    function(settings, data, dataIndex ) {
	        var minval  = $('#min-date').val();
	        var maxval  = $('#max-date').val();
            if (minval == "" && maxval == "") { return true; }

	        var startDateString = data[1];
			var dateParts = startDateString.split("-");
			var startDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0].substr(0,2));

            if(maxval == ""){
            	var min = new Date(minval);
            	if(startDate.getTime() >= min.getTime()){
            		return true;
            	}
            }
            if(minval == ""){
            	var max = new Date(maxval);
            	if(startDate.getTime() <= max.getTime()){
            		return true;
            	}
            }

	        var min = new Date(minval);
	        var max = new Date(maxval);
	        if (startDate.getTime() <= max.getTime() && startDate.getTime() >= min.getTime()) { return true; }
	        return false;
	    }
	);

    $(document).on("click",'#dateRangeSubmit',function(e){
        table.draw();
    });
</script>
@endpush
