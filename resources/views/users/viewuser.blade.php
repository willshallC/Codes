<?php //echo'<pre>';print_r($user);echo'</pre>';die; ?>
@extends('layouts.app', ['page' => __('Employee Details'), 'pageSlug' => 'users'])

@section('content')

<?php $image_path = config('global.image_path'); ?>

<?php //echo'<pre>';print_r($user);echo'</pre>';die; ?>
<div class="row profile_employee">
	<div class="col-md-12">
		<div class="card ">
			
			<h1 class="card-title">{{ __('Employee Details') }}</h1>

			<div class="col-md-12 p-0 profile-my_1 employee_management-profile">

				@include('alerts.success')
				<div class="profile-edit-left profile_details col-sm-12 p-0">
					
					<div class="img-sec-profile-sec">
						<img  class="img-responsive" src="{{ $image_path  }}/{{ $user->profile_pic ?? 'employee.jpg' }}">
					</div>

					<div class="content-sec-profile-sec">

						<table class="table tablesorter " id="">

							<tbody>

								<tr>
									<td colspan="2">	
						<h3> {{ $user->name }}</h3>
						<span>{{ $user->designation }}</span>
						<p> {{ $user->info }}</p>
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
									<td> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
								</tr>

								<tr>
									<td>Joining Date: </td>
									<td>{{ $user->joining_date != "" ? date('d-m-Y',strtotime($user->joining_date)) : "N/A"  }}</td>
								</tr>

								<tr>
									<td>Department: </td>
									<td>{{ $user->department != "" ? $user->department : "N/A"  }}</td>
								</tr>

								<tr>
									<td>Designation: </td>
									<td>{{ $user->designation != "" ? $user->designation : "N/A"  }}</td>
								</tr>

								<tr>
									<td>Qualification: </td>
									<td>{{ $user->qualification != "" ? $user->qualification : "N/A"  }}</td>
								</tr>

								<tr>
									<td>Core Skills: </td>
									<td>{{ $user->core_skills != "" ? $user->core_skills : "N/A"  }}</td>
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
								<td>{{ $user->gender != "" ? $user->gender : "N/A"  }}</td>
							</tr>

							<tr>
								<td>DOB: </td>
								<td>{{ $user->dob == "" ? "N/A" : date('d-m-Y',strtotime($user->dob)) }}</td>
							</tr>

							<!-- <tr>
								<td>Created at: </td>
								<td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
							</tr> -->
							<tr>
								<td>Marital Status: </td>
								<td>{{ $user->marital_status != "" ? $user->marital_status : "N/A"  }}</td>
							</tr>

							<tr>
								<td>Account Status: </td>
								<td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
							</tr>

							<tr>
								<td>Phone Number:  </td>
								<td> {{ $user->phone_personal != "" ? $user->phone_personal : "N/A"  }} </td>
							</tr>

							<tr>
								<td>Emergency Contact:  </td>
								<td>{{ $user->phone_emergency != "" ? $user->phone_emergency : "N/A"  }} </td>
							</tr>

							<tr>
								<td>Current Address: </td>
								<td>{{ $user->address_present != "" ? $user->address_present : "N/A"  }}</td>
							</tr>

							<tr>
								<td>Permanent Address: </td>
								<td>{{ $user->address_permanent != "" ? $user->address_permanent : "N/A"  }}</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>

		<?php if(isset($projects[0]) && !empty($projects[0])){ ?>
			<div class="table-date-content user_assign_projects">
				<table class="table-bttn">
					<tbody>
						<tr>
							<th colspan="2"><strong>Projects assigned</strong></th>
						</tr>
						<tr class="employee_times">
							<td colspan="2">
								<table class="table table-striped table-bordered table-hover">
									<tr>
										<?php $counter = 0; $totalProjects = count($projects);
										foreach($projects as $p){ ?>
											<?php if($counter%4 == 0){ ?>
												</tr>
												<tr>
											<?php } ?>
											<td>
												<a href="{{ route('view-project',$p->id)}}">{{$p->project_title}}</a>
											</td>
										<?php $counter++; } ?>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table> 
			</div>
		<?php } ?>

		<div class="card-footer p-0 card-footer py-2 nttt">

			<a href="{{ route('user.index') }}" class="btn  btn-primary1">Back</a>
			<a href="{{ route('user.edit', $user->id) }}" class="btn">Edit Profile</a>

		</div>
	</div>
</div>
</div>

@endsection
