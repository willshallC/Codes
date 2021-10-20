@extends('layouts.app', ['pageSlug' => 'ba-worksheets'])

@section('content')
	<?php //echo '<pre>';print_r($sales_executive);echo'</pre>';die; ?>
	
	<?php
	$selectedEmployee = isset($_GET['employee']) ? $_GET['employee'] : "";
	$selectedStatus = isset($_GET['status']) ? $_GET['status'] : "";
	$selectedDate = isset($_GET['date']) ? $_GET['date'] : date("d-m-Y");
$selectedDateTo = isset($_GET['to_date']) ? $_GET['to_date'] : '';
	
	?>

<div class="col-12">
	<h2 class="card-title">BA Worksheets</h1>
</div>

	<form class="employee_dsr1" action="" method="GET" name="dsr-view">
		<div class="row ba_worksheets">

		<br>
		
		<div class="dsr-prod col-md-12">
			<div class="form-group col-md-3">
				<h5>Select Employee</h5>
				<div class="controls">
					<select id="employees" class="form-control" name="employee">
						<option selected="selected" value="">Select Employee</option>
						@foreach($sales_executives as $sales_executive)
						<option value="{{$sales_executive->id}}">{{$sales_executive->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group col-md-3">
				<h5>Select Status</h5>
				<div class="controls">
					<select id="status" class="form-control" name="status">
						<option value="">Select Status</option>
						<option value="1">Active</option>
						<option value="2">Hot Lead</option>
						<option value="3">Hired</option>
					</select>
				</div>
			</div>
		
				<div id="date" class="form-group col-md-3" style="display:block">
				<h5>Select From Date</h5>
				<input id="lead_date" class="form-control" type="text" name="date" value="" autocomplete="off">
				</div>	

				<div id="date2" class="form-group col-md-3" style="display:block">
					<h5>Select To Date</h5>
					<input id="lead_date2" class="form-control" type="text" name="to_date" value="" autocomplete="off">
				</div>
	

			<div class="text-left bttm col-md-12" style="margin-left: 15px;top: 25px;">
				<input type="submit" id="btnFiterSubmitSearch" class="btn btn-info" value="Submit">
				<a href="{{ route('ba-worksheets') }}">Reset filters</a>
			</div>
			</div>
		</div>
	</form>
	<p><br></p>
	<p><br></p>
	
	
	<?php 
	
	if($allLeads->count())
	{
		
	}
	
	
	
	$tableStart = '	<table class="table table-striped table-bordered table-hover dsr_datas drs_22 ba_worksheet tppcs" id="project_list">
		<thead>
		    <th class="max">Title</th>
		    <th class="min">Profile</th>
			<th class="min">Platform</th>
			<th>Cost</th>
			<th>Status</th>
		</thead>
		<tbody>';
	$tableEnd = '</tbody>
    </table>';
	$employee_id = 0;
	$lead_date = 0;
	$tableStartcount = 0;
	$counter = 0;
	//$dsrTime = 0;
	$totalRecords = $allLeads->count();
	?>

	@foreach($allLeads as $lead)
	<?php
	
	if($lead->employee_id != $employee_id || $lead->date != $lead_date)
	{
		$employee_id = $lead->employee_id;
		$lead_date = $lead->date;
		//$tableStartcount = 0;
		if($tableStartcount > 0)
		{
			//echo "<tr><td colspan='3' style='text-align: right;'><strong>Total Time : </strong></td><td><strong>".minsToHours($dsrTime)."</strong><td></tr>";
			//$dsrTime = 0;
			echo $tableEnd;
			
		}

		if($counter < $totalRecords)
		{
			
			?>
			</br>
			<div class="row">
				<div class="col-12 Dsr_heading">
					<center><strong>{{ $lead->name }} ({{ date('d-m-Y',strtotime($lead->date)) }})</center>
				</div>
				<div class="col-12"></div>
			</div>
			<?php
			echo $tableStart;
		}
		$tableStartcount++;
	}
	$counter++;
	
	//$dsrTime +=  $lead->time_spent;
	?>
	<tr>
		<td>
			<a href="{{ $lead->job_url }}" target="_blank"> {{ $lead->job_title }} </a>
		</td>
		<td>{{ $lead->profile_id }}</td>
		<td>{{ $lead->platform }}</td>
		
		<td>
			{{ $lead->cost }}/{{ $lead->cost_type == 1 ? 'Hourly' : 'Fixed' }} 
		</td>
		<td>{{ $lead->status == 1 ? 'Active' : ( $lead->status == 2 ? 'Hot Lead' : ($lead->status == 3 ? 'Hired' : '')) }}</td>	
	</tr>
	<?php
	if($counter == $totalRecords)
	{
		//echo "<tr><td colspan='3' style='text-align: right;'><strong>Total Time : </strong></td><td><strong>".minsToHours($dsrTime)."</strong><td></tr>";
		//$dsrTime = 0;
		echo $tableEnd;
	}
	?>
	@endforeach
	<!-- <div>
		<h1>No projects to display</h1>
	</div> -->
	
	


	
	<link rel="stylesheet" href="{{{ URL::asset('custom/css/datepicker.css')}}}">
@endsection


@push('js')
<script src="{{{ URL::asset('custom/js/jquery-ui.min.js')}}}"></script>
<script>
jQuery(document).ready(function()
{
	jQuery("#employees").val('<?php echo $selectedEmployee; ?>');
	jQuery("#status").val('<?php echo $selectedStatus; ?>');
	jQuery("#lead_date").val('<?php echo $selectedDate; ?>');
	jQuery("#lead_date2").val('<?php echo $selectedDateTo; ?>');

	jQuery("#lead_date").datepicker({
		dateFormat: "dd-mm-yy",
		endDate: "today",
		maxDate: "today"
	});

	jQuery("#lead_date2").datepicker({
		dateFormat: "dd-mm-yy",
		endDate: "today",
		maxDate: "today"
	});
	
	
});
</script>
@endpush