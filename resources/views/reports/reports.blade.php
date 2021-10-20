@extends('layouts.app', ['pageSlug' => 'reports'])

@section('content')
<?php //echo '<pre>';print_r($projects);echo'</pre>';die; ?>

<?php
$selectedProject = isset($_GET['project']) ? $_GET['project'] : "" ;
$selectedEmployee = isset($_GET['employee']) ? $_GET['employee'] : "";
$selectedDepartment = isset($_GET['department']) ? $_GET['department'] : "";
?>
<div class="col-12">
	<h2 class="card-title">Reports</h1>
	</div>

	<form class="full-width" action="" method="GET" name="dsr-view">
		<div class="row">
			<br>
			<div class="d-flex dsr-prod col-md-12">
				<div class="form-group col-md-4">
					<h5>Select Project</h5>
					<div class="controls">
						<select id="project" class="form-control" name="project">
							<option value="" selected="selected">Select Project</option>
							@foreach($projects as $project)
							<option value="{{ $project->id }}"  <?php if($selectedProject ==  $project->id) {echo 'selected="selected"';} ?>>{{ $project->project_title }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group col-md-4">
					<h5>Select Department</h5>
					<div class="controls">
						<select id="department" class="form-control" name="department" {{ $selectedDepartment == '' && $selectedProject == '' ? 'disabled' : '' }}>
							<option value="" selected="selected">Select Department</option>
							@foreach($departments as $department)
							<option value="{{ $department->id }}"  <?php if($selectedDepartment ==  $department->id) {echo 'selected="selected"';} ?>>{{ $department->department }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group col-md-4 employees-filter">
					<h5>Select Employee</h5>
					<div class="controls">
						<select id="employees" class="form-control" name="employee" {{ $selectedEmployee == '' && $selectedProject == '' ? 'disabled' : '' }}>
							<option selected="selected" value="">Select Employee</option>
							@foreach($employees as $employee)
							<option value="{{ $employee->id }}" <?php if($selectedEmployee ==  $employee->id) {echo 'selected="selected"';} ?>>{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				
			</div>
			<div class="text-left bttm col-md-12" style="margin-left: 15px;top: 25px;">
					<input type="submit" id="btnFiterSubmitSearch" class="btn btn-info" value="Submit">
					<a class="reset-btn" href="{{ route('reports') }}">Reset filters</a>
				</div>
		</div>
	</form>
	<p><br></p>
	<p><br></p>
	
	<?php if(isset($dsr) && ($selectedProject != '' || $selectedEmployee != '')){ ?>
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
		<th>Work Date</th>
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

		if($dsrRow->user_id != $employee_id)
		{
			$employee_id = $dsrRow->user_id;
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
					<center><strong>Report of {{ $dsrRow->name }}'s Time</center>
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
			<td class="title">{{ date('d-m-Y',strtotime($dsrRow->dsr_date)) }}</td>
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
	<?php } ?>


	<!-- The Modal -->
	<div class="modal fade" id="myModal2">
		<div class="modal-dialog">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="modal-body">
					<div class="row">
						<div class="table-res-mobile">
							<table class="model-table">
								<thead>
									<tr>
										<th>Work Date</th>
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
		jQuery(document).ready(function(){
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

			jQuery(document).on("change","#project",function(){
				if(jQuery(this).val() != ''){
					jQuery("#employees").prop('disabled', false);
					jQuery("#department").prop('disabled', false);
				}else{
					jQuery("#employees").prop('disabled', true);
					jQuery("#department").prop('disabled', true);
				}
				// if(jQuery(this).val() != ''){
				// 	jQuery(".employees-filter").removeClass('d-none');
				// }else{
				// 	jQuery(".employees-filter").addClass('d-none');
				// }
			});
		});
	</script>
	@endpush