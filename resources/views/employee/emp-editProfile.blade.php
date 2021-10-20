@extends('employee.layouts.emp-app', ['pageSlug' => 'edit-profile'])

@section('content')

<?php $image_path = config('global.image_path');  //echo $image_path; ?>


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


 <div class="row profile_employee">
        <div class="col-md-12">
            <div class="card ">
			
			 <h1 class="card-title">{{ __('Edit Profile') }}</h1>
			 
			        <div class="col-md-12 p-0 profile-my_1">
					

                        <form method="post" action="{{ route('save-profile') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf

<div class="profile-my_2">

					<div class="profile-edit-left col-sm-6 p-0">
					
					<div class="img-sec-profile-sec">
					<div class="img-sec-profile-inner">
					<img id="profile-pic" class="img-responsive" src="{{ $image_path  }}{{ auth()->user()->profile_pic ?? 'employee.jpg' }}" />
					<input type="file" id="profile-pic-input" class="form-control" name="photo[]"/>
					</div>
					
					
					</div>
					
					<div class="content-sec-profile-sec">
										
					<table class="table tablesorter " id="">
					<thead class=" text-primary">
					<tr>
					<th colspan="2">{{ __('Official Information') }}</th>
					</tr>
					</thead>

					<tbody>


					<tr>
					
					<td>  <label class="form-control-label" for="input-phone_personal">{{ __('Name:') }}</label> </td>
					<td> <div class="form-control">{{ $user->name }}</div></td>
					
					</tr>


					<tr>
					
					<td> <label class="form-control-label" for="input-phone_personal">{{ __('Email:') }}</label> </td>
					<td> <input type="email" value="{{ $user->email }}" class="form-control disabled"></td>
					
					</tr>

					<tr>
					
					<td>  <label class="form-control-label" for="input-phone_personal">{{ __('Joining on:') }}</label> </td>
					<td> <div class="form-control">{{ $user->joining_date }}</div></td>
					
					</tr>


					<tr>
					
					<td> <label class="form-control-label" for="input-phone_personal">{{ __('Department:') }}</label> </td>
					<td> <div class="form-control">{{ $user->department }}</div></td>
					
					</tr>


					<tr >
					
					<td>  <label class="form-control-label" for="input-phone_personal">{{ __('Designation:') }}</label> </td>
					
					<td> <div class="form-control">{{ $user->designation }}</div></td>
					
					
					</tr>


					<tr class="form-group{{ $errors->has('qualification') ? ' has-danger' : '' }}">
					
					<td>  <label class="form-control-label" for="input-qualification">{{ __('Qualification:') }}</label> </td>
					
					<td>  <input type="text" name="qualification" id="input-qualification" class="form-control form-control-alternative{{ $errors->has('qualification') ? ' is-invalid' : '' }}" placeholder="{{ __('Qualification') }}" value="{{ old('qualification', $user->qualification) }}" required autofocus> </td>
					</tr>



					<tr class="form-group{{ $errors->has('core_skills') ? ' has-danger' : '' }}">
					<td style="vertical-align: top;">   <label class="form-control-label" for="input-core_skills">{{ __('Core Skills:') }}</label></td>
					
					<td> <textarea type="text" name="core_skills" id="input-core_skills" class="form-control form-control-alternative{{ $errors->has('core_skills') ? ' is-invalid' : '' }}" placeholder="{{ __('Core Skills') }}" >{{ old('core_skills', $user->core_skills) }}</textarea>
					</td>
					
					</tr>


					</tbody>
					</table>

					
					
					</div>
					
					</div>



     	<div class="profile-edit-right col-sm-6 p-0">


  <table class="table tablesorter " id="">
                            <thead class=" text-primary">
							<tr>
							<th colspan="2">{{ __('Personal Information') }}</th>
							</tr>
                            </thead>
							
							
							   <tbody>
                                   
									
									  <tr>
									  
									<td>  <label class="form-control-label" for="input-gender">{{ __('Gender:') }}</label></td>
									
									<td>  <select name="gender" id="input-gender" class="form-control form-control-alternative" placeholder="{{ __('Gender') }}" required value="{{ old('gender', $user->gender) }}">
                                        <option value="" disabled="disabled" selected="selected">Please select your Gender</option>
										<option value="Male" {{ $user->gender == "Male" ? "selected='selected'" : '' }}>Male</option>
										<option value="Female" {{ $user->gender == "Female" ? "selected='selected'" : '' }}>Female</option>
                                    </select>
									</td>
									
									</tr>
									
									
									
										  <tr class="form-group{{ $errors->has('marital_status') ? ' has-danger' : '' }}">
										  
									<td>    <label class="form-control-label" for="input-marital_status">{{ __('Marital Status:') }}</label></td>
									
									<td>  <select name="marital_status" id="input-marital_status" class="form-control form-control-alternative" required>
                                        <option value="" disabled="disabled" selected="selected">Please select your Marital Status</option>
										<option value="Single" {{ $user->marital_status == "Single" ? "selected='selected'" : '' }}>Single</option>
										<option value="Married" {{ $user->marital_status == "Married" ? "selected='selected'" : '' }}>Married</option>
                                    </select>
									
									
									</td>
									</tr>
							
							
								
									  <tr class="form-group{{ $errors->has('dob') ? ' has-danger' : '' }}">
									<td>        <label class="form-control-label" for="input-dob">{{ __('DOB:') }}</label>
									</td>
									
									<td>
								
									    <input type="text" name="dob" id="input-dob" class="form-control form-control-alternative{{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="{{ __('yyyy-mm-dd') }}" value="{{ old('dob', $user->dob) }}" required autofocus>
									</td>
									</tr>
							
							
							
								  <tr class="form-group{{ $errors->has('phone_personal') ? ' has-danger' : '' }}">
									<td>  <label class="form-control-label" for="input-phone_personal">{{ __('Phone Number') }}:</label></td>
									
									<td>  <input type="text" name="phone_personal" id="input-phone_personal" class="form-control form-control-alternative{{ $errors->has('phone_personal') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone Number (Personal)') }}" value="{{ old('phone_personal', $user->phone_personal) }}" required autofocus>
									
									</td>
									</tr>
							
							
							
								  <tr class="form-group{{ $errors->has('phone_emergency') ? ' has-danger' : '' }}">
									<td>  <label class="form-control-label" for="input-phone_emergency">{{ __('Emergency Contact') }}:</label></td>
									
									<td> 
									<input type="text" name="phone_emergency" id="input-phone_emergency" class="form-control form-control-alternative{{ $errors->has('phone_emergency') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone Number (Emergency)') }}" value="{{ old('phone_emergency', $user->phone_emergency) }}" required autofocus>
									</td>
									
									</tr>
									
									
									  <tr class="form-group{{ $errors->has('address_present') ? ' has-danger' : '' }}">
									<td>    <label class="form-control-label" for="input-address_present">{{ __('Current Address ') }}:</label></td>
									
									<td> 
									 <input type="text" name="address_present" id="input-address_present" class="form-control form-control-alternative{{ $errors->has('address_present') ? ' is-invalid' : '' }}" placeholder="{{ __('Address (Present)') }}" value="{{ old('address_present', $user->address_present) }}" required autofocus>
									
									</td>
									</tr>
									
									
									 
									 <tr class="form-group{{ $errors->has('address_permanent') ? ' has-danger' : '' }}">
									<td>  <label class="form-control-label" for="input-address_permanent">{{ __(' Permanent Address') }}:</label>
									</td>
									
									<td>
									
									   <input type="text" name="address_permanent" id="input-address_permanent" class="form-control form-control-alternative{{ $errors->has('address_permanent') ? ' is-invalid' : '' }}" placeholder="{{ __('Address (Permanent)') }}" value="{{ old('address_permanent', $user->address_permanent) }}" required autofocus>
									
									</td>
									</tr>
							
									<tr class="form-group{{ $errors->has('info') ? ' has-danger' : '' }}">
									<td style="vertical-align: top;">  <label class="form-control-label" for="input-info">{{ __('More Info') }}:</label>
									</td>
									
									<td>
									   <textarea type="text" name="info" id="input-info" class="form-control form-control-alternative{{ $errors->has('info') ? ' is-invalid' : '' }}" placeholder="{{ __('More Info') }}" required autofocus>{{ old('info', $user->info) }}</textarea>
									</td>
									</tr>
							
							
                             </tbody>
                        </table>
					
   </div>      
   </div>      

<div class="card-footer edit_11 p-0 card-footer py-2 ">

					<a href="{{ route('my-profile') }}" class="btn  btn-primary1">{{ __('Back') }}</a>
					<button type="submit" class="btn btn-success mt-4">{{ __('Update profile') }}</button>

					</div>
   </div>
							 
                        </form>
						
						
						
             
                </div>
				
				
				
            
				
        
            </div>
        </div>
        </div>
 
	<style>
	.main-panel > .content .below-content-all form .form-group .form-control-label {
    display: block !important;
	}
	</style>
	<link rel="stylesheet" href="{{{ URL::asset('custom/css/datepicker.css')}}}">
@endsection
@push('js')
<script src="{{{ URL::asset('custom/js/jquery-ui.min.js')}}}"></script>
<script>
jQuery("#input-dob").datepicker({
		dateFormat: "yy-mm-dd",
		endDate: "today",
		maxDate: "today",
		changeYear: true,
		yearRange: "-100:+0"
	});
</script>
<script>
function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
           // $('#uploadForm + img').remove();
            jQuery('#profile-pic').attr('src',e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

jQuery("#profile-pic-input").change(function () {
    filePreview(this);
});
</script>
@endpush
