@extends('employee.layouts.emp-app', ['page' => __('Fill DSR'), 'pageSlug' => 'fill-dsr'])
@section('content')
<?php //echo '<pre>';print_r($todaysDsr);echo'</pre>';die;?>
	<link rel="stylesheet" href="{{ URL::asset('custom/css/jquery-ui.min.css') }}" type="text/css">
	<div class=""><h2>Fill Daily Status Report</h2></div>

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
	<form method="post" action="{{ route('save-employee-dsr') }}">
		@csrf
		<div class="row">
	        <div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label" for="input-project">Select Project</label>
	        			<select class="form-control" name="project_id">
	        				<option disabled="disabled" selected="selected">Select Project</option>
							@foreach ($assignedProjects as $assignedProject)
	        				<option  value="{{ $assignedProject->id}}">{{ $assignedProject->project_title}}</option>
							@endforeach
	        			</select>
	        		</div>
	        	</div>
	        </div>
	        <div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label">Date</label>
	        			<div class="form-control"><?php echo date('d-m-Y'); ?></div>
	        		</div>
	        	</div>
	        </div>
			<div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label" for="input-category">Category</label>
	        			<select class="form-control" name="category_id" id="project-category" />
							<option disabled="disabled" selected="selected">Select Category</option>
							@foreach ($categories as $category)
								<option value="{{ $category->id }}">{{ $category->category }}</option>
							@endforeach
	        			</select>
	        		</div>
	        	</div>
	        </div>
			<div class="col-12 subcategory-div" style="display:none;">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label" for="input-sub_category">Sub-Category</label>
	        			<select class="form-control" name="subcategory_id" id="project-subcategory" />
							
	        			</select>
	        		</div>
	        	</div>
	        </div>
			
			
			<div class="col-12 time-bali-div">
	   				<label>Time Spent</label>
	        		<div class="form-group">
	        		
	        			<select class="form-control form-control-alternative" name="hours_spent">
	        				<option selected="selected" disabled="disabled">Hrs</option>
	        				<option value="0">0 hour</option>
	        				<option value="1">1 hour</option>
	        				<option value="2">2 hours</option>
	        				<option value="3">3 hours</option>
	        				<option value="4">4 hours</option>
	        				<option value="5">5 hours</option>
	        				<option value="6">6 hours</option>
	        				<option value="7">7 hours</option>
	        				<option value="8">8 hours</option>
	        			</select>
	        			<!-- <input class="form-control form-control-alternative" placeholder="Time spent" value="" required="true" autofocus="" name="time_spent" /> -->
	        		</div>
	        	
				
					
	        		<div class="form-group">
	        		
	        			<select class="form-control form-control-alternative" name="minutes_spent">
	        				<option selected="selected" disabled="disabled">Mins</option>
	        				<?php for($i=0;$i<60;$i=$i+5){ ?>
	        					<option value="<?php echo $i; ?>"><?php echo $i; ?> min.</option>
	        				<?php } ?>
	        			</select>
	        			<!-- <input class="form-control form-control-alternative" placeholder="Time spent" value="" required="true" autofocus="" name="time_spent" /> -->
	        		</div>
	        	</div>
	      
			
			<div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label" for="input-time_spent">Description</label>
	        			<textarea class="" name="description" placeholder="Description"></textarea>
	        		</div>
	        	</div>
	        </div>
	        <div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<input type="checkbox" class="replied_emails" value="Replied all the Emails" required="true"/> Replied all the Emails <p class="red-error1 d-none">Please tick this box</p>
	        		</div>
	        	</div>
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<input type="checkbox" class="updated_tl" value="Updated to TL" required="true"/> Updated to TL <p class="red-error2 d-none">Please tick this box</p>
	        		</div>
	        	</div>
	        </div>
	        <div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<input class="form-control submitbutton" type="submit" placeholder="Submit">
	        		</div>
	        	</div>
	        </div>
    	</div>
	</form>

	<?php if(count($todaysDsr)){ ?>
		</br>
	

		<div class="table-res-mobile">
		<table id="user-project-list" class="table table-striped table-bordered table-hover dataTable no-footer project_dsr-1">
			<thead>
				<tr>
					<th>Project</th>
					<th>Category</th>
					<th>Sub-category</th>
					<th>Time Spent</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($todaysDsr as $todayDsr)
					<?php $time[] = $todayDsr->time_spent; ?>
					<tr>
						<td>
							{{ $todayDsr->project_title }}
						</td>
						<td>
							{{ $todayDsr->category }}
						</td>
						<td>
							<?php if($todayDsr->subcategory){ ?>
								{{ $todayDsr->subcategory }}
							<?php }else{ ?>
								N/A
							<?php } ?>
						</td>
						<td>
							<?php
								$time_spent = $todayDsr->time_spent;
								$hours = floor($time_spent/60);
								$mins = $time_spent - $hours*60;
								if($hours > 0)
									$hours .= $hours > 1 ? " hours " : " hour ";
								else
									$hours = "";
								$mins = $mins." mins";
								echo $hours.$mins;
							?>
						</td>
						<td>
						
						<a class="all_icons" href="{{ route('edit-dsr',$todayDsr->id) }}"><img src="{{ asset('/') }}/custom/images/edit-icon.svg" title="Edit"></a>
						
						
						</td>
					</tr>
				@endforeach
				
				
				<tr class="totla_drs_1">
			<td colspan="3" style="text-align: right;"><strong>Total Time Spent: </strong></td>
			<td><strong><?php $total_time = array_sum($time);
				$time_spent = $total_time;
				$hours = floor($time_spent/60);
				$mins = $time_spent - $hours*60;
				if($hours > 0)
					$hours .= $hours > 1 ? " hours " : " hour ";
				else
					$hours = "";
				$mins = $mins." mins";
				echo $hours.$mins;
			?></strong>
			</td>
			<td></td>
			</tr>
			</tbody>
		</table>
		
	
	</div>
		
	<?php } ?>

@endsection

@push('js')
<script>
var categories = [];
<?php 
$categoryId = 0;
foreach($subcategories as $subcategory)
{
	if($categoryId != $subcategory->categories_id)
	{
		$categoryId = $subcategory->categories_id;
		?>
		categories[<?php echo $subcategory->categories_id;  ?>] = [{id:"<?php echo $subcategory->subcategories_id;  ?>",name:"<?php echo $subcategory->subcategory;  ?>"}];
		<?php
	}
	else
	{
		?>
		categories[<?php echo $subcategory->categories_id;  ?>].push({id:"<?php echo $subcategory->subcategories_id;  ?>",name:"<?php echo $subcategory->subcategory;  ?>"});
		<?php
	}
}
?>

jQuery("#project-category").change(function()
{
	var category = jQuery(this).val();
	
	if(categories[category] != undefined && categories[category].length > 0)
	{
		jQuery("#project-subcategory").html('');
		jQuery("#project-subcategory").append(jQuery('<option disabled="disabled" selected="selected">Select Sub-Category</option>'));
		jQuery(categories[category]).each(function()
		{
			jQuery("#project-subcategory").append(jQuery('<option value="'+jQuery(this)[0].id+'">'+jQuery(this)[0].name+'</option>'));
		});
		jQuery(".subcategory-div").show();
	}
	else
	{
		jQuery(".subcategory-div").hide();
		jQuery("#project-subcategory").html('');
	}
});

jQuery(document).ready(function(){
	jQuery(document).on("click",".submitbutton",function(e){
		if(!jQuery(".replied_emails").prop("checked")){
			jQuery(".red-error1").removeClass("d-none");
			e.preventDefault();
		}else{
			jQuery(".red-error1").addClass("d-none");
		}
		if(!jQuery(".updated_tl").prop("checked")){
			jQuery(".red-error2").removeClass("d-none");
			e.preventDefault();
		}else{
			jQuery(".red-error2").addClass("d-none");
		}
	});
});
</script>
@endpush