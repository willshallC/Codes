@extends('employee.layouts.emp-app', ['pageSlug' => 'team-dsr'])

@section('content')
<?php //echo '<pre>';print_r($dsr);echo'</pre>';die; ?>

<?php
$selectedEmployee = isset($_GET['employee']) ? $_GET['employee'] : "";
$selectedStartDate = isset($_GET['start_date']) ? $_GET['start_date'] : "";
$selectedEndDate = isset($_GET['end_date']) ? $_GET['end_date'] : "";
?>





<div class="col-12">
	<h2 class="card-title">Team DSR</h1>
	</div>

	<form action="" method="GET" name="dsr-view">
		<div class="row">		
			<div class="dsr-prod col-md-12">
				<div class="form-group col-md-12">
					<h5>Select Employee</h5>
					<div class="controls">
						<select id="employees" class="form-control" name="employee">
							<option selected="selected" value="">Select Employee</option>
							@foreach($employees as $emp)
							<option value="{{ $emp->id }}">{{ $emp->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div id="date-range">
					<div class="form-group col-md-12">
						<h5>Select Start Date</h5>
						<input id="dsr_date_start" class="form-control datepicker-autoclose" type="text" name="start_date" value="<?php echo $selectedStartDate != "" ?  $selectedStartDate : date('Y-m-d'); ?>">
					</div>
					<div class="form-group col-md-12 end-dsr-date" style="display:none">
						<h5>Select End Date</h5>
						<input id="dsr_date_end" class="form-control datepicker-autoclose" type="text" name="end_date" value="<?php echo $selectedEndDate != "" ?  $selectedEndDate : date('Y-m-d'); ?>">
					</div>
				</div>
				<div class="text-left bttm col-md-12" style="margin-left: 15px;top: 25px;">
					<input type="submit" id="btnFiterSubmitSearch" class="btn btn-info" value="Submit">
					<a href="{{ route('tl/team-dsr') }}">Reset filters</a>
				</div>
			</div>
		</div>
	</form>
	<p><br></p>
	<p><br></p>
	
	
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
				<center><strong>DSR of {{ $dsrRow->name }} ({{ $dsrRow->dsr_date }})</center>
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
		function resetFilters()
		{
			jQuery("#employees").val("");
			jQuery("#dsr_date_start").attr("name","");
			jQuery("#dsr_date_end").attr("name","");
		}

		function show_date_options()
		{
			if(jQuery("#employees").val() != "")
			{
				jQuery(".end-dsr-date").show();
				jQuery("#dsr_date_end").attr("name","end_date");
			}
			else
			{
				jQuery(".end-dsr-date").hide();
				jQuery("#dsr_date_end").attr("name","");
			}
		}

		jQuery("#employees").change(function()
		{
			show_date_options();
		});

		jQuery(document).ready(function()
		{
			jQuery("#employees").val(<?php echo $selectedEmployee; ?>);

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
	</script>
	@endpush