<?php $user = auth()->user();
if($user->access_level == "1"){
    $layout = 'layouts.app';
    $pageSlug = 'view-task';
}else{
    $layout = 'employee.layouts.emp-app';
    $pageSlug = 'view-task';
}
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

<?php 
if($task->quote){
    $hours = floor($task->quote/60);
    $mins = $task->quote - $hours*60;
    $mins .= " mins";
    $hours .= $hours && $hours > 1 ? " hrs" : ($hours && $hours == 1 ? " hr"  : "");
    $quote = $hours > 0 ? $hours.' '.$mins : $mins ;
}else{
    $quote = "N/A";
}

$string_data['status'] = array(
    '1' => 'Not Started Yet',
    '2' => 'Working',
    '3' => 'Waiting for Feedback',
    '4' => 'Working on Bug Fixing',
    '5' => 'Working on Additional Changes',
    '6' => 'Done'
);
$string_data['payment_status'] = array(
    '1' => 'Paid',
    '2' => 'Unpaid'
);
?>

    <div class="row">
        <div class="col-md-12 view_headering">
            <div class="card">
                <div class="card-title">Task Details</div>
                <div class="">
                    <table class="table tablesorter " id="">
                        <thead class=" text-primary">
                            <tr>
                                <th colspan="2">Project: {{ $task->website }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Upwork Code</td>
                                <td>{{ $task->upwork_code ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Time</td>
                                <td>{{ $quote }}</td>
                            </tr>
                            <tr>
                                <td>Amount</td>
                                <td>${{ $task->amount ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Task Date</td>
                                <td>{{ isset($task->date) ? date('d-m-Y',strtotime($task->date)) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Trello URL</td>
                                <td><a href="{{ $task->trello_url ?? '#' }}" target="_blank">{{ $task->trello_url ?? 'N/A' }}</a></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ isset($task->status) ? $string_data['status'][$task->status] : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td>{{ isset($task->payment_status) ? $string_data['payment_status'][$task->payment_status] : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Comments</td>
                                <td>{{ $task->comments ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
			<div class="card-footer p-0 card-footer card-foote22 py-2">
				<a class="btn  btn-primary1" href="{{ url('/mirror-sheet') }}" class="btn">Back</a>
				<a href="{{ url('edit-task',$task->id) }} " class="btn btn-sm btn-primary">Edit Task</a>
			</div>
        </div>
    </div>

@endsection