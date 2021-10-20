<?php
$layout = 'employee.layouts.emp-app';
$pageSlug = 'add-lead';
?>

@extends($layout, ['pageSlug' => $pageSlug])

@section('content')
<?php //echo '<pre>';print_r($user);echo'</pre>';die; ?>

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

<?php if(isset($job)){ ?>
    <h2 >{{ __('Edit Lead') }}</h2>
<?php }else{ ?>
    <h2 >{{ __('Add Lead') }}</h2>
<?php } ?>

<div class="container-fluid mt--7 p-0">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">

                <div class="card-body employee_managements add-job create">
                    <?php if(isset($oldJob)){ ?>
                        <form method="post" action="{{ route('save-edited-old-job',$job->id) }}" autocomplete="off">
                    <?php }else if(isset($job)){ ?>
                        <form method="post" action="{{ route('save-edited-job',$job) }}" autocomplete="off">
                    <?php }else{ ?>
                        <form method="post" action="{{ route('save-job') }}" autocomplete="off">
                    <?php } ?>

                        @csrf
                        <div class="add-project11">

	                    <div class="left_project12 left2">
	                    	<div class="form-group">
                                <input type="text" name="job_title" id="input-job_title" class="form-control form-control-alternative" placeholder="Job Title" value="{{ isset($job->job_title) ? $job->job_title : '' }}" required autofocus <?php if(isset($oldJob)){ echo "disabled"; } ?>>
                            </div>

                            <div class="form-group">
								<select name="platform" id="input-platform" class="form-control form-control-alternative" <?php if(isset($oldJob)){ echo "disabled"; } ?>>
								<option value="Upwork">Upwork</option>
								<option value="PPH">PPH</option>
								<option value="Fiverr">Fiverr</option>
								</select>
                            </div>
                             
							<div class="form-group">
								<div class="row">
								<div class="col-md-5">
                                     <div class="hrs">
	                                <input type="radio" name="cost_type" id="input-cost_hourly" class="" <?php echo isset($job->cost_type) && ($job->cost_type == 1) ? 'checked="checked"' : '' ?> value="1" >
									<span  style=" margin: 0 5px;">Hourly</span>
									<input type="radio" name="cost_type" id="input-cost_fixed" class="" <?php echo isset($job->cost_type) && ($job->cost_type == 2) ? 'checked="checked"' : '' ?> value="2" >
									<span  style=" margin: 0 5px;">Fixed</span>
                                 </div>
							   </div>

							   <div class="col-md-7">
                                <input type="text" name="cost" id="input-cost" class="form-control form-control-alternative" placeholder="Cost" value="{{ isset($job->cost) ? $job->cost : '' }}" required autofocus>
                               </div>

                            </div>
                            </div>
							
                            

                            <!--div class="form-group">
                                <textarea  name="comments" id="input-comments" class="form-control form-control-alternative" placeholder="Comments">{{ isset($job->comments) ? $job->comments : '' }}</textarea>
                            </div-->
                            
                       </div>
						
						<div class="right_project12 left2">
							<div class="form-group">
                                <input type="text" name="job_url" id="input-job_url" class="form-control form-control-alternative" placeholder="Job Url" value="{{ isset($job->job_url) ? $job->job_url : '' }}" required autofocus <?php if(isset($oldJob)){ echo "disabled"; } ?>>
                            </div>
							  <div class="form-group">
                                <input type="text" name="profile_id" id="input-profile_id" class="form-control form-control-alternative" placeholder="Profile Name" value="{{ isset($job->profile_id) ? $job->profile_id : '' }}" autofocus <?php if(isset($oldJob)){ echo "disabled"; } ?>>
                            </div>

                           <div class="form-group">
                                <select name="status" id="input-status" class="form-control form-control-alternative" placeholder="status" value="{{ isset($job->status) ? $job->status : '' }}" >
								<option value="">Select Status</option>
								<option value="1">Active</option>
								<option value="2">Hot Lead</option>
								<option value="3">Hired</option>
								</select>
                            </div>

                            <div class="text-left" style="text-align: left !important;margin: 0 0 20px;">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>

                         </div>   
                        </div>
                    </form>
					
					
					
					
					<?php if(isset($todaysLeads) && count($todaysLeads)){ ?>
						</br>
					

						<div class="table-res-mobile">
						<table id="user-project-list" class="table table-striped table-bordered table-hover dataTable no-footer project_dsr-1 tppcs">
							<thead>
								<tr>
									<th class="max">Title</th>
									<th class="min">Profile</th>
									<th class="min">Platform</th>																		
									<th>Cost</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($todaysLeads as $todayLead)
									<tr>
										<td>
											<a href="{{ $todayLead->job_url }}" target="_blank"> {{ $todayLead->job_title }} </a>
										</td>
										<td>
											{{ $todayLead->profile_id }}
										</td>
										<td>
											{{ $todayLead->platform }}
										</td>
										
										<td>
											{{ $todayLead->cost }}/{{ $todayLead->cost_type == 1 ? 'Hourly' : 'Fixed' }} 
										</td>
										<td>
											{{ $todayLead->status == 1 ? 'Active' : ( $todayLead->status == 2 ? 'Hot Lead' : ($todayLead->status == 3 ? 'Hired' : '')) }}
										</td>
										<td>
										<a class="all_icons" href="{{ route('edit-lead',$todayLead->id) }}"><img src="/custom/images/edit-icon.svg" title="Edit"></a>
										<a class="all_icons delete-job-entry" href="javascript:void(0);" data-link="{{ route('delete-job',$todayLead->id) }}"><img src="/custom/images/delete-icon.svg" title="Delete"></a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						
					
					</div>
						
					<?php } ?>
					
					<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Warning</h4>
							</div>
							<div class="modal-body">Are you sure you want to delete this Entry?</div>
							<div class="modal-footer">
								<a type="button" class="btn btn-primary" id="delete-job-confirm-btn" href="">Confirm</a>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
					
					
					
                </div>
                <div class="card-footer p-0 card-footer card-foote22 py-2">
                   <a href="{{ isset($job) ? route('add-lead') : route('home') }}" class="btn  btn-primary1">{{ __('Back') }}</a>
               </div>
           </div>
       </div>
   </div>
</div>

@endsection

@push('js')
<script>
jQuery(document).ready(function(){
	
	jQuery("#input-platform").val("<?php echo isset($job->platform) ? $job->platform : 'Upwork' ;?>")
	jQuery("#input-status").val("<?php echo isset($job->status) ? $job->status : '' ;?>")
	
	jQuery(document).on("click",".delete-job-entry",function(){
			jQuery("#demoModal").modal("show");
			jQuery("#delete-job-confirm-btn").attr('href',jQuery(this).attr('data-link'));
	});
	
	

	jQuery("#input-cost").keydown(function () {
    var txtQty = $(this).val().replace(/[^0-9\.]/g,'');
    jQuery(this).val(txtQty);
	});
	
});
</script>
@endpush

