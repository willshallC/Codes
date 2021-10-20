@extends('employee.layouts.emp-app', ['page' => __('Edit Old Date DSR'), 'pageSlug' => 'edit-olddate-dsr'])
@section('content')
<?php //echo '<pre>';print_r($todaysDsr);echo'</pre>';die;?>
	<link rel="stylesheet" href="{{ URL::asset('custom/css/jquery-ui.min.css') }}" type="text/css">
	<div class=""><h2>Edit Old Date Daily Status Report</h2></div>

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
	<form method="post" action="{{ route('save-edited-olddate-dsr',$dsrData->token_number) }}">
		@csrf
		<input type="text" class="d-none" name="id" value="{{ $todaysDsr->id }}">
		<div class="row">
	        <div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label" for="input-project">Select Project</label>
	        			<select class="form-control" name="project_id">
	        				<option disabled="disabled" selected="selected">Select Project</option>
							@foreach ($assignedProjects as $assignedProject)
	        					<option {{ $todaysDsr->project_id == $assignedProject->id ? 'selected="selected"' : '' }} value="{{ $assignedProject->id }}">{{ $assignedProject->project_title}}</option>
							@endforeach
	        			</select>
	        		</div>
	        	</div>
	        </div>
	        <div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label">Date</label>
	        			<div class="form-control">
	        				<?php if(isset($dsrData)){
        						echo date('d-m-Y',strtotime($dsrData->issued_for_date));
        					}else{
        						echo date('d-m-Y');
        					} ?>
	        			</div>
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
								<option {{ $todaysDsr->cat_id == $category->id ? 'selected="selected"' : '' }} value="{{ $category->id }}">{{ $category->category }}</option>
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
			<?php 
				$time_spent = $todaysDsr->time_spent;
				$hours = floor($time_spent/60);
				$mins = $time_spent - $hours*60;
			?>
			<div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label">Hours spent</label>
	        			<select class="form-control form-control-alternative" name="hours_spent">
	        				<option selected="selected" disabled="disabled">Select Hours spent</option>
	        				@for($i=0;$i < 9;$i++)
	        					<option {{ $hours == $i ? 'selected="selected"' : '' }} value="{{$i}}">{{$i}} hour{{ $i>1 ? 's' : '' }}</option>
	        				@endfor
	        			</select>
	        		</div>
	        	</div>
	        </div>
			<div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label">Minutes spent</label>
	        			<select class="form-control form-control-alternative" name="minutes_spent">
	        				<option selected="selected" disabled="disabled">Select Minutes spent</option>
	        				<?php for($i=0;$i<60;$i=$i+5){ ?>
	        					<option {{ $mins == $i ? 'selected="selected"' : '' }} value="<?php echo $i; ?>"><?php echo $i; ?> min.</option>
	        				<?php } ?>
	        			</select>
	        		</div>
	        	</div>
	        </div>
			<div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<label class="form-control-label" for="input-time_spent">Description</label>
	        			<textarea class="" name="description">{{ $todaysDsr->description }}</textarea>
	        		</div>
	        	</div>
	        </div>
	        <div class="col-12">
	        	<div class="col-sm-6">
	        		<div class="form-group">
	        			<input class="form-control" type="submit" placeholder="Submit">
	        		</div>
	        	</div>
	        </div>
    	</div>
	</form>
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
jQuery("#project-category").change();
jQuery("#project-subcategory").val("<?php echo isset($todaysDsr->subcat_id) && !empty($todaysDsr->subcat_id) ? $todaysDsr->subcat_id : '' ?>");
</script>
@endpush