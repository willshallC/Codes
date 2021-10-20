@extends('layouts.app', ['pageSlug' => 'dsr'])

@section('content')

<?php
$selectedDepartment = isset($_GET['department']) ? $_GET['department'] : "" ;
$selectedDate = isset($_GET['date']) ?  $_GET['date'] : "";
$selectedEmployee = isset($_GET['employee']) ? $_GET['employee'] : "";
$selectedStartDate = isset($_GET['start_date']) ? $_GET['start_date'] : "";
$selectedEndDate = isset($_GET['end_date']) ? $_GET['end_date'] : "";

function getWorkingDays($startDate,$endDate,$holidays){
	$endDate = strtotime($endDate);
	$startDate = strtotime($startDate);
	$days = ($endDate - $startDate) / 86400 + 1;

	$no_full_weeks = floor($days / 7);
	$no_remaining_days = fmod($days, 7);
	$the_first_day_of_week = date("N", $startDate);
	$the_last_day_of_week = date("N", $endDate);
	if ($the_first_day_of_week <= $the_last_day_of_week) {
		if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
		if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
	}
	else {
		if ($the_first_day_of_week == 7) {
			$no_remaining_days--;

			if ($the_last_day_of_week == 6) {
				$no_remaining_days--;
			}
		}
		else {
			$no_remaining_days -= 2;
		}
	}
	$workingDays = $no_full_weeks * 5;
	if ($no_remaining_days > 0 )
	{
		$workingDays += $no_remaining_days;
	}
	foreach($holidays as $holiday){
		$time_stamp=strtotime($holiday);
		if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
			$workingDays--;
	}

	return $workingDays;
}
?>

<div class="col-12">
	<h2 class="card-title">Employees DSR</h1>
	</div>

	<form class="employee_dsr1" action="" method="GET" name="dsr-view">
		<div class="row">

			<br>

			<div class="dsr-prod col-md-12">
				<div class="form-group col-md-3">
					<h5>Select Department</h5>
					<div class="controls">
						<select id="department" class="form-control" name="department">
							<option value="" selected="selected">Select Department</option>
							@foreach($departments as $department)
							<option value="{{ $department->id }}"  <?php if($selectedDepartment ==  $department->id) {echo 'selected="selected"';} ?>>{{ $department->department }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group col-md-3">
					<h5>Select Employee</h5>
					<div class="controls">
						<select id="employees" class="form-control" name="employee">
							<option selected="selected" value="">Select Employee</option>
						</select>
					</div>
				</div>
				<div id="date" class="form-group col-md-3">
					<h5>Select Date</h5>
					<input id="dsr_date" class="form-control datepicker-autoclose" type="text" name="date" value="<?php echo $selectedDate != "" ?  $selectedDate : date('Y-m-d'); ?>">
				</div>
				<div id="date-range" class="col-md-6 form-group " style="display:none">
					<div class="form-group col-md-6">
						<h5>Select Start Date</h5>
						<input id="dsr_date_start" class="form-control datepicker-autoclose" type="text" name="start_date" value="<?php echo $selectedStartDate != "" ?  $selectedStartDate : date('Y-m-d'); ?>">
					</div>
					<div class="form-group col-md-6">
						<h5>Select End Date</h5>
						<input id="dsr_date_end" class="form-control datepicker-autoclose" type="text" name="end_date" value="<?php echo $selectedEndDate != "" ?  $selectedEndDate : date('Y-m-d'); ?>">
					</div>
				</div>
				<input type="hidden" id="hdn_date" name="hdn_date" value="date">
				<div class="text-left bttm col-md-12" style="margin-left: 15px;top: 25px;">
					<input type="submit" id="btnFiterSubmitSearch" class="btn btn-info" value="Submit">
					<a href="{{ route('dsr') }}">Reset filters</a>
				</div>
			</div>
		</div>
	</form>
	<p><br></p>
	<p><br></p>
	
	@if($selectedStartDate && $selectedEndDate)
	<div class="col-12 dsr-prod">
		<h5><span>Total Working Days:</span> <?php echo getWorkingDays($selectedStartDate,$selectedEndDate,array()); ?> days</h5>
		@if(isset($employeeWorked[0]) && !empty($employeeWorked[0]))
			<h5><span>Employee's Working Days:</span> <?php echo count($employeeWorked); ?> days</h5>
		@endif
	</div>
	@endif
	
	<?php 
	
	function minsToHours($time_spent)
	{
		$hours = floor($time_spent/60);
		$mins = $time_spent - $hours*60;
		if($hours > 0)
			$hours .= $hours > 1 ? " hrs " : " hr ";
		else
			$hours = "";
		$mins = $mins." mins";
		return $hours.$mins;
	}
	
	$tableStart = '	<table class="table table-striped table-bordered table-hover dsr_datas drs_22" id="project_list">
	<thead>
	<th>Project Name</th>
	<th>Category</th>
	<th>Sub-Category</th>
	<th>Time Spent</th>
	<th class="d-none">Description</th>
	<th>Action</th>
	</thead>
	<tbody>';
	$tableEnd = '</tbody>
	</table>';
	$employee_id = 0;
	$dsr_date = 0;
	$tableStartcount = 0;
	$counter = 0;
	$dsrTime = 0;
	$totalRecords = $dsr->count();
	?>

	@foreach($dsr as $dsrRow)
	<?php
	
	if($dsrRow->user_id != $employee_id || $dsrRow->dsr_date != $dsr_date)
	{
		$employee_id = $dsrRow->user_id;
		$dsr_date = $dsrRow->dsr_date;
		//$tableStartcount = 0;
		if($tableStartcount > 0)
		{
			echo "<tr><td colspan='3' style='text-align: right;'><strong>Total Time : </strong></td><td><strong>".minsToHours($dsrTime)."</strong><td></tr>";
			$dsrTime = 0;
			echo $tableEnd;
			
		}

		if($counter < $totalRecords)
		{
			
			?>
		</br>
		<div class="row">
			<div class="col-12 Dsr_heading">
				<center><strong>{{ $dsrRow->name }} ({{ date('d-m-Y',strtotime($dsrRow->dsr_date)) }})</center>
				</div>
				<div class="col-12"></div>
			</div>
			
			<?php
			echo $tableStart;
		}
		$tableStartcount++;
	}
	$counter++;
	
	$dsrTime +=  $dsrRow->time_spent;
	?>
	<tr>
		<td class="title">{{ $dsrRow->project_title}}</td>
		<td class="category">{{ $dsrRow->category}}</td>
		<td class="subcategory">{{ $dsrRow->subcategory}}</td>
		<td class="timespent"> <?php echo minsToHours($dsrRow->time_spent);?> </td>
		<td class="description d-none">{{ $dsrRow->description }}</td>
		<td><a href="javascript:void(0);" class="viewDSRbutton all_icons" data-toggle="modal" data-target="#myModal2" target="_blank" ><img title="View Detail" src="{{ asset('/') }}custom/images/view-icon.svg"></a></td>
		

	</tr>
	<?php
	if($counter == $totalRecords)
	{
		echo "<tr><td colspan='3' style='text-align: right;'><strong>Total Time : </strong></td><td><strong>".minsToHours($dsrTime)."</strong><td></tr>";
		$dsrTime = 0;
		echo $tableEnd;
	}
	?>
	@endforeach
	<!-- <div>
		<h1>No projects to display</h1>
	</div> -->
	
	


	<!-- The Modal -->
	<div class="modal fade" id="myModal2">
		<div class="modal-dialog">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<!-- Modal body -->
				<div class="modal-body">
					<div class="row">

						<div class="table-res-mobile">
							<table class="model-table">
								<thead>
									<tr>
										<th>Project Name</th>
										<th>Category</th>
										<th>Sub-Category</th>
										<th>Time Spent</th>
										<th>Description</th>

									</tr>
								</thead>

								<tr>
									<td><div class="dsr-title "></div>	</td>
									<td><div class="dsr-category "></div>	</td>
									<td><div class="dsr-subcategory"></div>	</td>
									<td><div class="dsr-timespent "></div></td>
									<td><div class="dsr-description "></div></td>
								</tr>
							</table>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-backdrop fade show"></div>
	</div>
	
	
	<link rel="stylesheet" href="{{{ URL::asset('custom/css/datepicker.css')}}}">
	@endsection


	@push('js')
	<script src="{{{ URL::asset('custom/js/jquery-ui.min.js')}}}"></script>
	<script>
		var employeees = [];
		<?php 
		$department_id = '';
		foreach($employees as $employee)
		{
			if($department_id != $employee->department_id)
			{
				$department_id = $employee->department_id;
				?>
				employeees[<?php echo $employee->department_id;  ?>] = [{id:"<?php echo $employee->id;  ?>",name:"<?php echo $employee->name;  ?>"}];
				<?php
			}
			else
			{
				?>
				employeees[<?php echo $employee->department_id;  ?>].push({id:"<?php echo $employee->id;  ?>",name:"<?php echo $employee->name;  ?>"});
				<?php
			}
		}
		?>

		jQuery("#department").change(function()
		{
			var department = jQuery(this).val();

			if(employeees[department] != undefined && employeees[department].length > 0)
			{
				jQuery('#employees option:not(:first)').remove();;
				jQuery(employeees[department]).each(function()
				{
					jQuery("#employees").append(jQuery('<option value="'+jQuery(this)[0].id+'">'+jQuery(this)[0].name+'</option>'));
				});
			}
			else
			{
				jQuery('#employees option:not(:first)').remove();
			}
			show_date_options();
		});

		jQuery("#employees").change(function()
		{
			show_date_options();
		});

		function show_date_options()
		{
			if(jQuery("#employees").val() != "")
			{
				jQuery("#date-range").show();
				jQuery("#date").hide();
				jQuery("#dsr_date_start").attr("name","start_date");
				jQuery("#dsr_date_end").attr("name","end_date");
				jQuery("#dsr_date").attr("name","");
				jQuery("#hdn_date").val("range");


			}
			else
			{
				jQuery("#date-range").hide();
				jQuery("#date").show();
				jQuery("#dsr_date_start").attr("name","");
				jQuery("#dsr_date_end").attr("name","");
				jQuery("#dsr_date").attr("name","date");
				jQuery("#hdn_date").val("date");
			}
		}

		jQuery(document).ready(function()
		{
			jQuery("#department").change();
			jQuery("#employees").val(<?php echo $selectedEmployee; ?>);
			jQuery("#dsr_date").datepicker({
				dateFormat: "yy-mm-dd",
				endDate: "today",
				maxDate: "today"
			});

			jQuery("#dsr_date_start").datepicker({
				dateFormat: "yy-mm-dd",
				endDate: "today",
				maxDate: "today",
				onSelect: function(dateText, inst) {
					jQuery('#dsr_date_end').datepicker('option', 'minDate', dateText);
				}
			});

			jQuery("#dsr_date_end").datepicker({
				dateFormat: "yy-mm-dd",
				endDate: "today",
				maxDate: "today",
				onSelect: function(dateText, inst) {
					jQuery('#dsr_date_start').datepicker('option', 'maxDate', dateText);
				}
			});
			jQuery("#employees").change();

			jQuery(document).on("click",".viewDSRbutton",function(e){
				var title = jQuery(this).parents("tr").find(".title").text();
				var category = jQuery(this).parents("tr").find(".category").text();
				var subcategory = jQuery(this).parents("tr").find(".subcategory").text();
				var timespent = jQuery(this).parents("tr").find(".timespent").text();
				var description = jQuery(this).parents("tr").find(".description").text();
				jQuery(".dsr-title").text(title);
				jQuery(".dsr-category").text(category);
				jQuery(".dsr-subcategory").text(subcategory);
				jQuery(".dsr-timespent").text(timespent);
				jQuery(".dsr-description").text(description);
			});
		});


		function resetFilters()
		{
			jQuery("#department").val("");
			jQuery("#employees").val("");
			jQuery("#dsr_date_start").attr("name","");
			jQuery("#dsr_date_end").attr("name","");
			jQuery("#dsr_date").attr("name","date");
			jQuery("#hdn_date").val("date");
		}
	</script>
	@endpush