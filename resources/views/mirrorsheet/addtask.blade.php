<?php $user = auth()->user();
if($user->access_level == "1"){
    $layout = 'layouts.app';
    $pageSlug = 'add-task';
}else{
    $layout = 'employee.layouts.emp-app';
    $pageSlug = 'add-task';
}

if(isset($task)){
    $pageSlug = 'edit-task';
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

<?php if(isset($task)){ ?>
    <h2 >{{ __('Edit Task') }}</h2>
<?php }else{ ?>
    <h2 >{{ __('Add Task') }}</h2>
<?php } ?>

<div class="container-fluid mt--7 p-0">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">

                <div class="card-body employee_managements create">
                    <?php if(isset($task)){ ?>
                        <form method="post" action="{{ route('save-edited-task',$task) }}" autocomplete="off">
                    <?php }else{ ?>
                        <form method="post" action="{{ route('save-task') }}" autocomplete="off">
                    <?php } ?>

                        @csrf
                        <div class="pl-lg-0">
                            <div class="form-group">
                                <select id="select-website" class="form-control" name="website">
                                    <option value="" selected="selected">Select Website</option>
                                    <option value="IM" {{ isset($task->website) && $task->website == "IM" ? 'selected="selected"' : '' }}>IM</option>
                                    <option value="ML" {{ isset($task->website) && $task->website == "ML" ? 'selected="selected"' : '' }}>ML</option>
                                    <option value="BCW" {{ isset($task->website) && $task->website == "BCW" ? 'selected="selected"' : '' }}>BCW</option>
                                </select>
                                <!-- <input type="text" name="website" id="input-website" class="form-control form-control-alternative" placeholder="Website" value="{{ isset($task->website) ? $task->website : '' }}" required autofocus> -->
                            </div>
                            <div class="form-group">
                                <input type="text" name="upwork_code" id="input-upwork_code" class="form-control form-control-alternative" placeholder="Upwork Code" value="{{ isset($task->upwork_code) ? $task->upwork_code : '' }}" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="number" name="quote" id="input-quote" class="form-control form-control-alternative" placeholder="Quote (in min.)" value="{{ isset($task->quote) ? $task->quote : '' }}" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="text" name="amount" id="input-amount" class="form-control form-control-alternative" placeholder="Amount" value="{{ isset($task->amount) ? $task->amount : '' }}" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="text" name="trello_url" id="input-trello" class="form-control form-control-alternative" placeholder="Trllo URL" value="{{ isset($task->trello_url) ? $task->trello_url : '' }}" required autofocus>
                            </div>
                            <div class="form-group">
                                <input type="date" name="date" id="input-date" class="form-control form-control-alternative" placeholder="Date" value="{{ isset($task->date) ? date('Y-m-d', strtotime($task->date)) : '' }}" required autofocus>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="comments">{{ isset($task->comments) ? $task->comments : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <select name="status" id="input-status" class="form-control form-control-alternative" placeholder="status" required>
                                    <option value="" disabled="disabled" selected="selected">Please select status</option>
                                    <option value="1" {{ isset($task->status) && $task->status == '1' ? 'selected="selected"' : '' }}>Not Started Yet</option>
                                    <option value="2" {{ isset($task->status) && $task->status == '2' ? 'selected="selected"' : '' }}>Working</option>
                                    <option value="3" {{ isset($task->status) && $task->status == '3' ? 'selected="selected"' : '' }}>Waiting for Feedback</option>
                                    <option value="4" {{ isset($task->status) && $task->status == '4' ? 'selected="selected"' : '' }}>Working on Bug Fixing</option>
                                    <option value="5" {{ isset($task->status) && $task->status == '5' ? 'selected="selected"' : '' }}>Working on Additional Changes</option>
                                    <option value="6" {{ isset($task->status) && $task->status == '6' ? 'selected="selected"' : '' }}>Done</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="payment_status" id="input-payment_status" class="form-control form-control-alternative" placeholder="status" required>
                                    <option value="" disabled="disabled" selected="selected">Please select Payment status</option>
                                    <option value="1" {{ isset($task->payment_status) && $task->payment_status == '1' ? 'selected="selected"' : '' }}>Paid</option>
                                    <option value="2" {{ isset($task->payment_status) && $task->payment_status == '2' ? 'selected="selected"' : '' }}>Unpaid</option>                                    
                                </select>
                            </div>

                            <div class="text-left" style="text-align: left !important;margin: 0 0 20px;">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer p-0 card-footer card-foote22 py-2">
                   <a href="{{ route('mirror-sheet') }}" class="btn  btn-primary1">{{ __('Back') }}</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection