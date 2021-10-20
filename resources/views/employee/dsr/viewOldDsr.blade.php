@extends('employee.layouts.emp-app', ['page' => __('Old Dsr'), 'pageSlug' => 'old-dsr'])
@section('content')

<div class="row">
	<div class="col-12">
	<h2 class="card-title">Old DSR</h1>
</div>
</div>

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
	$totalRecords = $viewOldDsr->count();

	?>

	@foreach($viewOldDsr as $dsrRow)
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
					<center><strong>DSR of {{ date('d-m-Y',strtotime($dsrRow->dsr_date)) }}</center>
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
<script>
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
</script>
@endpush