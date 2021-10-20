<?php //echo '<pre>';print_r($allbackdates);echo'</pre>';die; ?>

@extends('employee.layouts.emp-app', ['pageSlug' => 'all-backdate-request'])

@section('content')

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
<script src="{{{ URL::asset('datatable/datatables.min.js')}}}"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#all_backdate_requests').DataTable({

		});
	});
</script>
@endpush