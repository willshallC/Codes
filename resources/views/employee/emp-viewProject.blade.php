@extends('employee.layouts.emp-app', ['pageSlug' => 'assigned-projects'])

@section('content')
	<?php //echo '<pre>';print_r($projects);echo'</pre>';die; ?>



<div class="user" id="project_list_content">

	<h1>{{ $project->project_title }}</h1>
	<table class="url-information">
		<tbody>
			<?php if($project->url != ""): ?>
			<tr>
			<td>URL:</td>
			<td>{{ $project->url }}</td>
			</tr>
			<?php endif; ?>
			<!--tr>
			<td>Documents : </td>
			<td class="docunments-sec"><a href="#"><img src="/laravel/public/custom/images/doc-icon.svg"> <span>Project Description.docx</span></a> <a class="flow-charts" href="#"><img src="/laravel/public/custom/images/pdf-icon.svg">  <span>FlowChart.pdf</span></a></td>
			</tr-->

			<?php if($project->description != ""): ?>
			<tr class="descriptn">
			<td>Description : </td>
			<td>{{ $project->description }}</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<div class="table-date-content">
		<table class="table-devisie one">
			<tbody>
				<tr>
					<th colspan="2"><strong>Project Date & Information</strong></th>
				</tr>
			
				
				<tr>
					<td>Start Date: </td>
					<td>{{ $project->start_date != "" ?  date('d-m-Y', strtotime($project->start_date)) : "N/A" }}</td>
				</tr>
				<tr>
				
					<td>End Date:</td>
					<td>{{  $project->end_date != "" ? date('d-m-Y', strtotime($project->end_date)) : "N/A" }}</td>
				</tr>
				
				<tr>
					<td>Platform: </td>
					<td>{{ $project->platform != "" ? $project->platform : "N/A" }}</td>
				</tr>
				
				<?php  if($project->upwork_profile_name != ""): ?>
				<tr>
					<td>Profile: </td>
					<td>{{ $project->upwork_profile_name }}</td>
				</tr>
				<?php endif; ?>
				
				<?php /* ?><tr>
					<td>Priority: </td>
					<td>{{ $project->priority != "" ? $project->priority : "N/A" }}</td>
				</tr><?php */ ?>
				<tr>
					<td>Sales Executive:</td>
					<td>{{ $project->name != "" ? $project->name : "N/A" }}</td>
				</tr>
				<?php if($project->name == "Other"): ?>
			<tr>
                <td>Hire By:</td>
                <td>{{ $project->hired_by_other != "" ? $project->hired_by_other : "N/A"  }}</td>
            </tr>
			<?php endif; ?>
			</tbody>
		</table> 
		<?php 
		function minsToHours($time_spent)
		{
			$hours = floor($time_spent/60);
			$mins = $time_spent - $hours*60;
			if($hours > 0)
				$hours .= $hours > 1 ? " hours " : " hour ";
			else
				$hours = "";
			$mins = $mins." mins";
			return $hours.$mins;
		}
		?>
		<table class="table-devisie three">
			<tbody>
				<tr>
					<th colspan="2"><strong>Time & Cost</strong></th>
				</tr>
				<?php
					if(isset($project->time_allocated)){
						$hours = floor($project->time_allocated/60);
						$mins = $project->time_allocated - $hours*60;
						if($hours > 0){
							$hours .= $hours > 1 ? " hours " : " hour ";
						}
						else{
							$hours = "";
						}
						if($mins > 0){
							$mins = $mins." mins";
						}
						else{
							$mins = "";
						}
						
					}
				?>
				<tr>
					<td>Time Allocated : </td>
					<td>{{ $hours || $mins ? $hours . $mins : "N/A"  }}</td>
				</tr>
				<tr class="total-time">
					<td>Total Time Spent: </td>
					<td><?php echo minsToHours($time_spent[0]->total_time_spent); ?></td>
				</tr>
				<tr>
					<td>Time Spent by me: </td>
					<td><?php echo minsToHours($time_spent[0]->time_by_me); ?></td>
				</tr>
				<tr>
					<td>Billing Type: </td>
					<td>{{ $project->billing_type == 1 ? "Fixed" : "Hourly" }}</td>
				</tr>
			</tbody>
		</table> 
	</div>

	<div class="card-footer p-0 card-footer card-foote22 py-2">

 <a class="btn  btn-primary1" href="{{ url('/assigned-projects') }}" class="btn">Back</a>
                </div>
	
	
	
</div>

	<!-- <div>
		<h1>No projects to display</h1>
	</div> -->
@endsection