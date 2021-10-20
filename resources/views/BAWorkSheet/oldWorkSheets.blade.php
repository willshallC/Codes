@extends('employee.layouts.emp-app', ['page' => __('Old Work Sheets'), 'pageSlug' => 'old-work-sheets'])
@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

<div class="row">
	<div class="col-12">
	<h2 class="card-title">Old Work Sheets</h1>
</div>
</div>

<?php
	
	$tableStart = '	<table class="table table-striped table-bordered table-hover dsr_datas drs_22 tppcs" id="project_list">
		<thead>
		    <th class="max">Title</th>			
			<th class="min">Profile</th>
			<th class="min">Platform</th>			
			<th>Cost</th>
			<th>Status</th>
			<th>Action</th>
		</thead>
		<tbody>';
	$tableEnd = '</tbody>
    </table>';
	$employee_id = 0;
	$sheet_date = 0;
	$tableStartcount = 0;
	$counter = 0;
	$totalRecords = $viewOldSheets->count();

	?>

	@foreach($viewOldSheets as $sheetRow)
	<?php
	
	if($sheetRow->date != $sheet_date)
	{
		$sheet_date = $sheetRow->date;
		//$tableStartcount = 0;
		if($tableStartcount > 0)
		{
			echo $tableEnd;
		}

		if($counter < $totalRecords)
		{
			
			?>
			</br>
			<div class="row">
				<div class="col-12 Dsr_heading black-clr">
					<center><strong>{{ date('d-m-Y',strtotime($sheetRow->date)) }}</center>
				</div>
				<div class="col-12"></div>
			</div>
			
			<?php
			echo $tableStart;
		}
		$tableStartcount++;
	}
	$counter++;
	
	
	?>
	<tr>
		<td class="title">
			<a href="{{ $sheetRow->job_url }}" target="_blank"> {{ $sheetRow->job_title }} </a>
		</td>
		<td class="profile">{{ $sheetRow->profile_id}}</td>	
		<td class="platform">{{ $sheetRow->platform}}</td>
			
		<td>
			{{ $sheetRow->cost }}/{{ $sheetRow->cost_type == 1 ? 'Hourly' : 'Fixed' }} 
		</td>
		<td>
			{{ $sheetRow->status == 1 ? 'Active' : ( $sheetRow->status == 2 ? 'Hot Lead' : ($sheetRow->status == 3 ? 'Hired' : '')) }}
		</td>
		<td>
		<a class="all_icons" href="{{ route('edit-old-lead',$sheetRow->id) }}"><img src="/custom/images/edit-icon.svg" title="Edit"></a>
	</tr>
	<?php
	if($counter == $totalRecords)
	{
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