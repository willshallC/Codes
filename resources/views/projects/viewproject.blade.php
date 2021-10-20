@extends('layouts.app', ['pageSlug' => 'projects'])

@section('content')
	<?php //echo '<pre>';print_r($employees_assigned);echo'</pre>';die; ?>
	<?php 
		$totalhours = isset($employee_time_spent[0]) && !empty($employee_time_spent[0]) ? floor($employee_time_spent[0]->total_time/60) : "";

		$totalmins = isset($employee_time_spent[0]) && !empty($employee_time_spent[0]) ? $employee_time_spent[0]->total_time - $totalhours*60 : "";

		if($totalhours){ $totalhours .= " hours"; }
		if($totalmins){ $totalmins .= " mins"; }
	?>
	
	<div  class="admin-project" id="project_list_content">

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
				<td>{{ $project->start_date != "" ? date('d-m-Y', strtotime($project->start_date)) : "N/A" }}</td>
			</tr>
			
			
			<tr>
			
				<td>End Date: </td>
				<td>{{  $project->end_date != "" ? date('d-m-Y', strtotime($project->end_date)) : "On going" }}</td>
			</tr>
			
			<tr>
				<td>Platform: </td>
				<td>{{ $project->platform != "" ? $project->platform : "N/A"  }}</td>
			</tr>
			
			<?php  if($project->upwork_profile_name != ""): ?>
			<tr>
				<td>Profile: </td>
				<td>{{ $project->upwork_profile_name }}</td>
			</tr>
			<?php endif; ?>
			
			<?php /* ?><tr>
				<td>Priority: </td>
				<td>{{ $project->priority != "" ? $project->priority : "N/A"  }}</td>
			</tr> <?php */ ?>
			<tr>
				<td>Assigned To:</td>
				<?php if(isset($employees_assigned[0]) && !empty($employees_assigned[0])){ ?>
					<td>
						<?php $totalCount = 1;foreach($employees_assigned as $emp_assigned){ ?>
							<a href="{{ route('view-user',$emp_assigned->id) }}"><?php echo $emp_assigned->name; ?></a>
							<?php if(count($employees_assigned) != $totalCount){ echo ",";} ?>
							<?php $totalCount++; ?>
						<?php } ?>
						<?php //echo implode(",",$employees_assigned); ?>
					</td>
				<?php }else{ ?>
					<td><?php echo "Not assigned to any Employee"; ?></td>
				<?php } ?>
			</tr>		
        </tbody>
    </table> 
	
	
		<table class="table-devisie two">
        <tbody>
		
		<tr>
                <th colspan="2"><strong>Client & Sales Details</strong></th>
            </tr>
		
		<tr>
                <td>Client Name: </td>
				<td>{{ $project->client_name != "" ? $project->client_name : "N/A"  }}</td>
            </tr>
			
			<tr>
                <td>Email: </td>
				<td>{{ $project->client_email != "" ? $project->client_email : "N/A"  }}</td>
            </tr>
			
			<tr>
                <td>Skpye: </td>
				<td>{{ $project->client_skype != "" ? $project->client_skype : "N/A"  }}</td>
            </tr>
			
			<tr>
                <td>Country: </td>
				<td>{{ $project->client_country != "" ? $project->client_country : "N/A"  }}</td>
            </tr>
			<tr>
                <td>Sales Executive:</td>
                <td>{{ $project->name != "" ? $project->name : "N/A"  }}</td>
            </tr>
			
			<?php if($project->name == "Other"): ?>
			<tr>
                <td>Hire By:</td>
                <td>{{ $project->hired_by_other != "" ? $project->hired_by_other : "N/A"  }}</td>
            </tr>
			<?php endif; ?>
		
		</tbody>
    </table> 
	
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
                <td>Time Allocated: </td>
				<td>{{ $hours || $mins ? $hours . $mins : "N/A"  }}</td>
            </tr>
			<tr>
                <td>Billing Type: </td>
				<td>{{ $project->billing_type == 1 ? "Fixed" : "Hourly" }}</td>
            </tr>
			
			<tr class="total-time">
                <td>Total Time Spent: </td>
				<td>
					<?php if($totalhours || $totalmins){ ?>
						<?php echo $totalhours == 0 ? $totalmins : $totalhours .' '. $totalmins ?>
					<?php }else{ ?>
						N/A
					<?php } ?>
				</td>
            </tr>
			
			<tr>
                <td>{{ $project->billing_type == 1 ? "Project Cost" : "Hourly Rate" }}: </td>
				<td>{{ $project->project_cost != "" ? $project->project_cost : ($project->hourly_rate ? $project->hourly_rate : "N/A")  }}</td>
            </tr>
		
		</tbody>
    </table> 
		
	</div>

<div class="table-date-content">

	<table class="table-bttn">
        <tbody>
			<tr>
                <th colspan="2"><strong>Employees worked on it</strong></th>
            </tr>
            <?php if($totalhours || $totalmins){ ?>
				<tr class="employee_times">
					<td colspan="2">
						<table class="table table-striped table-bordered table-hover">
							<tr>
								<?php $counter = 0; $totalemployees = count($employee_time_spent);
								foreach($employee_time_spent as $employee_time){ ?>
									<?php 
										$hours = floor($employee_time->time_spent/60);
										$mins = $employee_time->time_spent - $hours*60;
										if($hours){ $hours .= " hours "; }else{ $hours = ""; }
										$mins .= " mins";
									?>
									<?php if($counter%4 == 0){ ?>
										</tr>
										<tr>
									<?php } ?>
									<td><a href="{{ route('view-user',$employee_time->id)}}">{{$employee_time->name}}</a> : {{ $hours . $mins}}</td>
									
								<?php $counter++; } ?>
							</tr>
						</table>
					</td>
	            </tr>
				<tr class="employee_totals">
					<td colspan="2">
						<table class="table table-striped table-bordered table-hover">
					
							<tr>
							<td colspan="3">&nbsp;</td>
								<td><a href="#">Total Time</a> : {{  $totalhours .' '. $totalmins }}</td>
							</tr>
						</table>
					</td>
	            </tr>
        	<?php } ?>
        </tbody>
    </table> 
	
		</div>


<div class="card-footer p-0 card-footer card-foote22 py-2">

<a class="btn  btn-primary1" href="{{ URL::previous() }}" class="btn">Back</a>
        	<a class="btn btn-success mt-4" href="{{ route('edit-project',$project->id) }}" class="btn">Edit Information</a>
        	<a class="btn btn-success mt-4" id="delete_project" href="javascript:void(0);">Delete</a>
                </div>
				
				

	</div>
		

<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Warning</h4>
            </div>
            <div class="modal-body">Are you sure you want to delete this Project?</div>
            <div class="modal-footer">
            	<a type="button" class="btn btn-primary" href="{{ route('delete-project',$project->id) }}">Confirm</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(document).on("click","#delete_project",function(){
			jQuery("#demoModal").modal("show");
		});
	});
</script>
@endpush