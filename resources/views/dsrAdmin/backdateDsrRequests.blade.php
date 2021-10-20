@extends('layouts.app', ['pageSlug' => 'backdate-dsr-requests'])

@section('content')
    <?php /* $status = array(
        '1' => 'Active',
        '2' => 'Completed',
        '3' => 'On-hold',
        '4' => 'Canceled',
        '5' => 'Dispute'
    ); */ ?>
	<?php //echo '<pre>';print_r($projects);echo'</pre>';die; ?>
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
        <div class=""><h2>Back Date DSR Requests</h2></div>
		
		<div class="table-res-mobile">
			<table class="table table-striped table-bordered table-hover new-bullet-class" id="dsr_tokens_list">
				<thead>
					<tr>
						<th>Name</th>
						<th>Department</th>
						<th>Request for date</th>
						<th>Requested at</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($backdateDsrRequests as $backdateDsrRequest)
				<tr>
					<td>{{$backdateDsrRequest->name}}</td>
					<td>{{$backdateDsrRequest->department}}</td>
					<td>{{date('d-m-Y', strtotime($backdateDsrRequest->issued_for_date))}}</td>
					<td>{{date('d-m-Y h:i:s', strtotime($backdateDsrRequest->requested_at))}}</td>
					<td><a href="{{ route('approve-backdate-dsr-request',$backdateDsrRequest->id) }}">Approve</a></td>
				</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		
		<div class="card-footer p-0 card-footer card-foote22 py-2">

   <a class="btn  btn-primary1" href="{{ url('/home') }}" class="btn">Back</a>
</div>
    </div>

	<!-- <div>
		<h1>No projects to display</h1>
	</div> -->
@endsection

@push('js')
	<script src="{{{ URL::asset('datatable/datatables.min.js')}}}"></script>
	<script type="text/javascript">
        jQuery(document).ready(function(){
		   	jQuery('#dsr_tokens_list').DataTable({
                
            });
		});
	</script>
@endpush