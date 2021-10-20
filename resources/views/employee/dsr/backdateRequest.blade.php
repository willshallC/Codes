@extends('employee.layouts.emp-app', ['page' => __('Backdate Request'), 'pageSlug' => 'backdate-request'])

@section('content')
<?php //echo '<pre>';print_r($allbackdates);echo'</pre>';die;?>
<link rel="stylesheet" href="{{ URL::asset('custom/css/jquery-ui.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{{ URL::asset('custom/css/datepicker.css')}}}">

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

<div class=""><h2>Backdate Daily Status Report Request</h2></div>

<form method="post" action="{{ route('save-backdate-request') }}">
	@csrf
	<div class="row">
		<div class="col-12">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="form-control-label" for="input-time_spent">Select Backdate</label>
					<input class="form-control backdate" type="text" name="issued_for_date" placeholder="Enter Backdate">
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="col-sm-6">
				<div class="form-group">
					<input class="form-control submitbutton" type="submit" value="Submit" placeholder="Submit">
				</div>
			</div>
		</div>
	</div>
</form>


<div class="main_listing_projects1">
	<div class=""><h2>All Back Date DSR Requests</h2></div>

	<div class="table-res-mobile">
		<table class="table table-striped table-bordered table-hover new-bullet-class" id="all_backdate_requests">
			<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Request for date</th>
					<th>Requested at</th>
					<th>Valid till date</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $counter = 1;
					$current_date = date('Y-m-d');
				?>
				@foreach ($allbackdates as $backdate)
				<tr>
					<td>{{ $counter }}</td>
					<td>{{ date('d-m-Y', strtotime($backdate->issued_for_date))}}</td>
					<td>{{ date('d-m-Y h:i:s', strtotime($backdate->requested_at))}}</td>
					<td>{{ $backdate->valid_till_date ? date('d-m-Y', strtotime($backdate->valid_till_date)) : 'N/A' }}</td>
					<td>{{ $backdate->valid_till_date ? ((strtotime($current_date) > strtotime($backdate->valid_till_date)) ? 'In-Valid' : 'Approved') : 'Not Approved Yet' }}</td>
					<td>
						<?php if($backdate->valid_till_date){
							if(strtotime($current_date) > strtotime($backdate->valid_till_date)){
								echo '-';
							}else{ ?>
								<a href="{{ route('add-old-date-dsr',$backdate->token_number) }}">Fill Dsr</a>
							<?php }
						}else{
						 	echo '-';
					 	} ?>
					</td>
				</tr>
				<?php $counter++; ?>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="card-footer p-0 card-footer card-foote22 py-2">
		<a class="btn btn-primary1" href="{{ url('/home') }}" class="btn">Back</a>
	</div>
</div>
@endsection

@push('js')
<script src="{{{ URL::asset('custom/js/jquery-ui.min.js')}}}"></script>
<script src="{{{ URL::asset('datatable/datatables.min.js')}}}"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#all_backdate_requests').DataTable({

		});
	});
</script>
<script>
	jQuery(document).ready(function(){
	    var today = new Date();
	    var yestreday = new Date();
    	yestreday.setDate(today.getDate() - 1);

		jQuery(".backdate").datepicker({
			//minDate: dateToday,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
            changeYear: true,
            maxDate: yestreday,
            beforeShowDay: function(date) {
				var day = date.getDay();
				return [day != 0,''];
			}
		});

		jQuery('#all_backdate_requests').DataTable();
	});

</script>
@endpush