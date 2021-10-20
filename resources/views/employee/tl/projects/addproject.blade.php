<?php if(isset($project) && !empty($project)){ ?>
	<?php $pageslug = ''; ?>
<?php }else{ ?>
	<?php $pageslug = 'tl/add-project'; ?>
<?php } ?>

@extends('employee.layouts.emp-app', ['pageSlug' => $pageslug])

@section('content')
<?php //echo'<pre>';print_r($project);echo'</pre>';die; ?>
<link rel="stylesheet" href="{{ URL::asset('custom/css/jquery-ui.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ URL::asset('multiselect/css/compiled-4.10.0.min.css') }}" type="text/css">
<?php if(isset($project) && !empty($project)){ ?>
	<div class=""><h2>Edit Project</h2></div>
<?php }else{ ?>
	<div class=""><h2>Add Project</h2></div>
<?php } ?>

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

<?php if(isset($project) && !empty($project)){ ?>
	<form id="add_projects1" method="post" action="{{ route('tl/save-edited-project') }}">
	<input type="hidden" name="id" value="{{ $project->id }}">
<?php }else{ ?>
	<form id="add_projects1" method="post" action="{{ route('tl/save-project') }}">
<?php } ?>
		@csrf
		
		<h4>Project Information</h4>
		<div class="add-project11">
			<div class="left_project12 left2">
				<div class="content-devices"> 
					<input class="form-control" name="project_title" placeholder="Title" value="{{ old('project_title') ? old('project_title') : (isset($project->project_title) ? $project->project_title : '') }}">
				</div>
				<div class="content-devices"> 
					<input class="form-control" name="url" placeholder="URL" value="{{ old('url') ? old('url') : (isset($project->url) ? $project->url : '') }}">

				</div>
				<div class="content-devices"> 
					<select class="form-control" id="department_ids" name="department_ids">
						<option disabled="disabled" selected="selected">Select Department</option>
						@foreach($departments as $val)
						<option value="{{$val->id}}">{{$val->department}}</option>
						@endforeach
					</select>

				</div>
				<div class="content-devices dates2"> 
					<div class="inner_content">
						<input class="form-control start-date" id="start-date" name="start_date" placeholder="Start Date" value="{{ old('start_date') ? old('start_date') : (isset($project->start_date) ? date('Y-m-d',strtotime($project->start_date)) : '') }}">
					</div>
					<div class="inner_content">
						<input class="form-control end-date" id="end-date" name="end_date" placeholder="End Date" value="{{ old('end_date') ? old('end_date') : (isset($project->end_date) ? date('Y-m-d',strtotime($project->end_date)) : '') }}">
					</div>	
				</div>
				<div class="content-devices"> 
					<textarea rows="4" class="form-control" name="description" placeholder="Description">{{ old('description') ? old('description') : (isset($project->description) ? $project->description : '') }}</textarea>

				</div>
				<div class="content-devices"> 
					<select class="form-control" id="status" name="status">
						<option disabled="disabled" selected="selected">Select Project Status</option>
						<option value="1">Active</option>
						<option value="2">Completed</option>
						<option value="3">On-Hold</option>
						<option value="4">Canceled</option>
						<option value="5">Dispute</option>
					</select>

				</div>
			</div>
			<div class="right_project12 left2">

				<div class="content-devices"> 
					<select class="form-control mdb-select colorful-select dropdown-primary md-form" id="assigned_users" name="assigned_users[]" multiple searchable="Search here..">
						<option disabled="disabled" selected="selected">Select Employees</option>
						@foreach($users as $val)
						<option value="{{$val->id}}">{{$val->name}}</option>
						@endforeach
					</select>
					<!-- <input type="button" value="x" id="clearusers" class="d-none"> -->
				</div>

				<!-- <div class="content-devices"> 
					<select class="form-control" id="priority" name="priority">
						<option disabled="disabled" selected="selected">Select Priority</option>
						<option value="Critical & Top">Critical & Top</option>
						<option value="High">High</option>
						<option value="Medium">Medium</option>
						<option value="Low">Low</option>
					</select>

				</div> -->
				
				<div class="content-devices"> 
					<select class="form-control" id="platform" name="platform">
						<option disabled="disabled" selected="selected">Select Platform</option>
						<option value="Upwork">Upwork</option>
						<option value="Fiverr">Fiverr</option>
						<option value="Direct">Direct</option>
					</select>
				</div>
				<div class="content-devices platform-based d-none"> 
					<input type="text" class="form-control" name="upwork_profile_name" placeholder="Upwork profile name" value="{{ old('upwork_profile_name') ? old('upwork_profile_name') : (isset($project->upwork_profile_name) ? $project->upwork_profile_name : '') }}">
				</div>

				<div class="content-devices"> 
					<select class="form-control billing_type_select" name="billing_type">
						<option disabled="disabled" selected="selected">Select Billing Type</option>
						<option value="1">Fixed</option>
						<option value="2">Hourly</option>
					</select>
				</div>

				<div class="content-devices project-cost d-none"> 
					<input type="number" class="form-control" name="project_cost" placeholder="Project Cost" value="{{ old('project_cost') ? old('project_cost') : (isset($project->project_cost) ? str_replace('$','',$project->project_cost) : '') }}">
				</div>
				
				<div class="content-devices hourly-rate d-none"> 
					<input type="number" class="form-control" name="hourly_rate" placeholder="Hourly Rate" value="{{ old('hourly_rate') ? old('hourly_rate') : (isset($project->hourly_rate) ? str_replace('$','',$project->hourly_rate) : '') }}">
				</div>

				<?php
				if(isset($project->time_allocated)){
					$hours = floor($project->time_allocated/60);
					$mins = $project->time_allocated - $hours*60;
				}else{
					$hours = '';
					$mins = '';
				}
				?>
				<div class="content-devices dates2">
					<div class="inner_content">
						<input type="number" class="form-control" name="time_allocated_hours" placeholder="Time Allocated (Hours)" value="{{ $hours }}">
						<?php if($hours){ ?><p>Time allocated in hours</p><?php } ?>
					</div>
					<div class="inner_content">
						<input type="number" class="form-control" name="time_allocated_mins" placeholder="Time Allocated (Minutes)" value="{{ $mins }}">
						<?php if($mins){ ?><p>Time allocated in mins.</p><?php } ?>
					</div>
				</div>
			</div>
		</div>
		<h4>Client Information</h4>
		<div class="add-project11">
			<div class="left_project12 left2">
				<div class="content-devices"> 
					<input class="form-control" name="client_name" placeholder="Client Name" value="{{ old('client_name') ? old('client_name') : (isset($project->client_name) ? $project->client_name : '') }}">
				</div>
				<div class="content-devices"> 
					<input class="form-control" name="client_email" placeholder="Client Email" value="{{ old('client_email') ? old('client_email') : (isset($project->client_email) ? $project->client_email : '') }}">
				</div>
				<div class="content-devices"> 
					<input class="form-control" name="client_skype" placeholder="Client Skype" value="{{ old('client_skype') ? old('client_skype') : (isset($project->client_skype) ? $project->client_skype : '') }}">
				</div>
			</div>

			<div class="right_project12 left2">
				<div class="content-devices"> 
					<select class="form-control" id="client_country" name="client_country">
                        <option selected="selected" value="" disabled>Select Client Country</option>
                        <option value="Australia">Australia</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="Canada">Canada</option>
                        <option value="Austria">Austria</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Greece">Greece</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Japan">Japan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Malaysia">Malaysia</option> 
                        <option value="Netherlands">Netherlands</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Poland">Poland</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Singapore">Singapore</option>
                        <option value="South Africa">South Africa</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                    </select> 

				</div>	

				<div class="content-devices"> 
					<select class="form-control" id="sales_executive" name="sales_executive">
						<option disabled="disabled" selected="selected">Sales Executive</option>
						@foreach($sales as $s)
						<option value="{{$s->id}}">{{$s->name}}</option>
						@endforeach
					</select>
				</div>	
				
				<div class="content-devices" id="hired_by_other_div" style="display:none"> 
					<input class="form-control" id="hired_by_other" name="hired_by_other" value="{{ old('hired_by_other') ? old('hired_by_other') : (isset($project->hired_by_other) ? $project->hired_by_other : '') }}" placeholder="Hired By">
				</div>	


			</div>

		</div>
		
		

		<div class="col-sm-12 p-0 ">
			<div class="form-group">
				<input class="form-control" type="submit" placeholder="Submit" value="Submit">
			</div>
	        		<!-- <div class="form-group">
	        			<a class="btn" href="{{ route('projects') }}">Cancel</a>
	        		</div> -->
	        	</div>

	        </form>
	        <link rel="stylesheet" href="{{{ URL::asset('custom/css/datepicker.css')}}}">
	        @endsection

	        @push('js')
	        <script src="{{{ URL::asset('multiselect/js/compiled.1023.min.js') }}}"></script>
	        <script src="{{{ URL::asset('multiselect/js/footer-functions.js')}}}"></script>
	        <script src="{{{ URL::asset('custom/js/jquery-ui.min.js')}}}"></script>
	        <script type="text/javascript">
	        	$(document).ready(function(){
	        		$(document).on("change",".billing_type_select",function(){
	        			var billing_type = $(this).children("option:selected").val();
	        			if(billing_type == "1"){
	        				$(".project-cost").removeClass("d-none");
	        				$(".hourly-rate").addClass("d-none");
	        			}else{
	        				$(".hourly-rate").removeClass("d-none");
	        				$(".project-cost").addClass("d-none");
	        			}
	        		});
	        		var dateToday = new Date();
	        		$(".start-date").datepicker({
						//minDate: dateToday,
						dateFormat: 'yy-mm-dd'
					});
	        		$(".end-date").datepicker({
						//minDate: dateToday,
						dateFormat: 'yy-mm-dd'
					});

// Code for Multiple select

$('#lang').materialSelect({
	language: {
		active: true,
		pl: {
			active: true
		}
	}
});
$('#lang1').materialSelect({
	language: {
		active: true,
		ge: {
			active: true
		}
	}
});
$('#lang2').materialSelect({
	language: {
		active: true,
		ar: {
			active: true
		}
	}
});
$('#lang3').materialSelect({
	language: {
		active: true,
		in: {
			active: true
		}
	}
});
$('#lang4').materialSelect({
	language: {
		active: true,
		fr: {
			active: true
		}
	}
})

$('#bs').materialSelect({
	BSsearchIn: true
});

// validation
$('.mdb-select.validate').materialSelect({
	destroy: true,
	validate: true,
	validFeedback: 'Correct choice',
	invalidFeedback: 'Wrong choice'
});

function validateSelect(e) {
	e.preventDefault();
	$('.needs-validation').addClass('was-validated');
	if ($('.needs-validation select').val() == '') {
		$('.needs-validation').find('.valid-feedback').hide();
		$('.needs-validation').find('.invalid-feedback').show();
		$('.needs-validation').find('.select-dropdown').val('').prop('placeholder', 'No countries selected')
	} else {
		$('.needs-validation').find('.valid-feedback').show();
		$('.needs-validation').find('.invalid-feedback').hide();
	}
}
$('.needs-validation select').on('change', e => validateSelect(e));
$('.needs-validation').on('submit', e => validateSelect(e));

jQuery("#sales_executive").change(function(){
	if(jQuery(this).val() == 30)
		$("#hired_by_other_div").show();
	else
		$("#hired_by_other_div").hide();
});

jQuery(document).on("change","#assigned_users", function(){
// jQuery("#select-options-assigned_users li").each(function(e){
// 	var checkboxes = jQuery(this).find("input");
// 	console.log("input = " + checkboxes.prop('checked'));
// });
// console.log("selected = " + jQuery(".select-dropdown.form-control").val());

//jQuery("#clearusers").removeClass("d-none");
});

jQuery(document).on("click","#clearusers", function(e){
// jQuery("#assigned_users").find(":selected").removeProp("selected");
// jQuery("#assigned_users").find(":disabled").prop("selected");
jQuery("#assigned_users").val('');
jQuery("#select-options-assigned_users li").removeClass("active").attr('aria-selected','false');
jQuery(".select-dropdown.form-control").val(jQuery("#assigned_users").find(":disabled").text());

jQuery("#select-options-assigned_users li").each(function(e){
	var checkboxes = jQuery(this).find("input");
	console.log("before = " + checkboxes.prop('checked'));
	if(checkboxes.prop("checked")){
		checkboxes.prop("checked", !checkboxes.prop("checked"));
	}
	console.log("after = " + checkboxes.prop('checked'));
});
jQuery("#select-options-assigned_users li").first().addClass("active").attr('aria-selected','true');
jQuery(this).addClass("d-none");
});

jQuery(document).on("change","#platform",function(){
	if(jQuery(this).children("option:selected").val() == "Upwork"){
		jQuery(".platform-based").removeClass("d-none");
	}else{
		jQuery(".platform-based").addClass("d-none");
		jQuery(".platform-based").find('input').val('');
	}
})
});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		// Section To select all select boxes old values or else the saved values

		var relations = <?php echo isset($project_user_relation[0]) && !empty($project_user_relation[0]) ? json_encode($project_user_relation) : json_encode(array()) ?>;

		$("#department_ids").val("<?php echo old('department_ids') ? old('department_ids') : (isset($project->department_ids) ? $project->department_ids : '') ?>");
		$("#platform").val("<?php echo old('platform') ? old('platform') : (isset($project->platform) ? $project->platform : '') ?>");
		$("#status").val("<?php echo old('status') ? old('status') : (isset($project->status) ? $project->status : '') ?>");
		$("#sales_executive").val("<?php echo old('sales_executive') ? old('sales_executive') : (isset($project->sales_executive) ? $project->sales_executive : '') ?>");
		$(".billing_type_select").val("<?php echo old('billing_type') ? old('billing_type') : (isset($project->billing_type) ? $project->billing_type : '') ?>");
		$("#client_country").val("<?php echo old('client_country') ? old('client_country') : (isset($project->client_country) ? $project->client_country : '') ?>");

		$("#assigned_users").val(relations);

		if($("#sales_executive").val() == 30)
			$("#hired_by_other_div").show();

		$("#sales_executive").change();
		$("#platform").change();
		$(".billing_type_select").change();
		// Section End

		if($("#department_ids").val() == '' || $("#department_ids").val() == null){
			$("#department_ids option:first").prop("selected",'true');
		}
		if($("#platform").val() == '' || $("#platform").val() == null){
			$("#platform option:first").prop("selected",'true');
		}
		if($("#status").val() == '' || $("#status").val() == null){
			$("#status option:first").prop("selected",'true');
		}
		if($("#sales_executive").val() == '' || $("#sales_executive").val() == null){
			$("#sales_executive option:first").prop("selected",'true');
		}
		if($(".billing_type_select").val() == '' || $(".billing_type_select").val() == null){
			$(".billing_type_select option:first").prop("selected",'true');
		}
		if($("#client_country").val() == '' || $("#client_country").val() == null){
			$("#client_country option:first").prop("selected",'true');
		}
	});
</script>
@endpush