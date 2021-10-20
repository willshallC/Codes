@extends('employee.layouts.emp-app', ['pageSlug' => 'my-profile'])

@section('content')
<?php $image_path = config('global.image_path'); ?>
    <div class="row profile_employee">
        <div class="col-md-12">
            <div class="card ">

                            <h1 class="card-title">{{ __('My Profile') }}</h1>

              
               <div class="col-md-12 p-0 profile-my_1 employee_management-profile">
                    @include('alerts.success')
					
					   <div class="profile-edit-left profile_details col-sm-12 p-0">
					
					<div class="img-sec-profile-sec">
					<img class="img-responsive" src="{{ $image_path  }}{{ auth()->user()->profile_pic ?? 'employee.jpg' }}" />
					<!--span>{{ $user->core_skills }}</span-->
					
					</div>
					
					
                      		<div class="content-sec-profile-sec">
							
							<table class="table tablesorter " id="">

							<tbody>

							<tr>
							<td colspan="2">	

								<h3>  {{ $user->name }}</h3>
									<span>{{ $user->designation }}</span>
								<p>{{ $user->info }}</p>

							</td>
							</tr>

							</tbody>
							</table>
							
							
						
					
							</div>
					
                      
                </div>
                </div>
					
					     <div class="col-md-12 p-0 profile-my_1 employee_management-profile  profile_full-sec">
					<div class="profile-edit-left col-sm-6 p-0">
					
				
					
					<div class="content-sec-profile-sec">
					
					    <table class="table tablesorter " id="">
                            <thead class=" text-primary">
							<tr>
							<th colspan="2">Official Information</th>
							</tr>
                            </thead>
							
                            <tbody>
                                    <tr>
									<td>Name: </td>
									<td>{{ $user->name }}</td>
									</tr>
									
									 <tr>
									<td>Email: </td>
									<td>{{ $user->email }}</td>
									</tr>
									
									 <tr>
									<td>Joined on: </td>
									<td>{{ $user->joining_date}}</td>
									</tr>
									
									 <tr>
									<td>Department: </td>
									<td>{{ $user->department }}</td>
									</tr>
									
									 <tr>
									<td>Designation: </td>
									<td>{{ $user->designation }}</td>
									</tr>
									
									 <tr>
									<td>Qualification: </td>
									<td>{{ $user->qualification }}</td>
									</tr>

									<tr>
									<td>Core Skills: </td>
									<td> {{ $user->core_skills }}</td>
								</tr>
									
									
                                        
                            </tbody>
                        </table>
					
					
					</div>
					
					</div>
					
					
					
					
					

                  	<div class="profile-edit-right col-sm-6 p-0">
                        <table class="table tablesorter " id="">
                              <thead class=" text-primary">
							<tr>
							<th colspan="2">Personal Information</th>
							</tr>
                            </thead>
							
							
                            <tbody>
							
							
							
									<tr>
									<td>Gender: </td>
									<td>{{ $user->gender }}</td>
									</tr>
									
									<tr>
									<td>DOB: </td>
									<td>{{ $user->dob }}</td>
									</tr>
									
									 <tr>
									<td>Marital Status: </td>
									<td>{{ $user->marital_status }}</td>
									</tr>
									
									
									 <tr>
									<td>Phone Number:  </td>
									<td>{{ $user->phone_personal }}</td>
									</tr>
									
									 <tr>
									<td>Emergency Contact:  </td>
									<td>{{ $user->phone_emergency }}</td>
									</tr>
									
									
									 <tr>
									<td>Current Address: </td>
									<td>{{ $user->address_present }}</td>
									</tr>
									
									
									 <tr>
									<td>Permanent Address: </td>
									<td>{{ $user->address_permanent }}</td>
									</tr>
									

                            </tbody>
                        </table>
                  </div>
				
                </div>
				
				
                <div class="card-footer p-0 card-footer py-2">

  <a href="{{ route('home') }}" class="btn  btn-primary1">{{ __('Back') }}</a>
  <a href="{{ route('edit-profile') }}" class="btn  btn-primary2">{{ __('Edit Profile') }}</a>
  <a href="{{ route('assigned-projects') }}" class="btn btn-primary3">{{ __('View Assigned Projects') }}</a>
                </div>
				
				
            </div>
        </div>
    </div>
@endsection
