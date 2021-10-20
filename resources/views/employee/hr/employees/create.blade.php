@extends('employee.layouts.emp-app', ['page' => __('Employee Management'), 'pageSlug' => 'hr/add-employee'])

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
	
	 <h2 >{{ __('Add Employee') }}</h2>
    <div class="container-fluid mt--7 p-0">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                   
                    <div class="card-body employee_managements create">
                        <form method="post" action="{{ route('hr/save-employee') }}" autocomplete="off">
                            @csrf

                           
                            <div class="pl-lg-0">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>
                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-department">{{ __('Department') }}</label>
                                    <select name="department_id" id="input-department" class="form-control form-control-alternative" placeholder="{{ __('Department') }}" required>
                                        <option value="" disabled="disabled" selected="selected">Please select employee department</option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->department}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-status">{{ __('Account Status') }}</label>
                                    <select name="status" id="input-status" class="form-control form-control-alternative" placeholder="{{ __('Account Status') }}" required>
                                        <option value="" disabled="disabled" selected="selected">Please select account status</option>
                                        <option value="1">Enable</option>
                                        <option value="0">Disable</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-status">{{ __('Designation') }}</label>
                                    <select name="designation" id="input-status" class="form-control form-control-alternative" placeholder="{{ __('Designation') }}" required>
                                        <option value="" disabled="disabled" selected="selected">Please select employee designation</option>
                                        @foreach($designation as $d)
                                            <option value="{{ $d->id }}">{{ $d->designation }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="form-control-label" for="input-status">{{ __('Select Permissions') }}</label>
                                    <select name="access_level" id="input-status" class="form-control form-control-alternative" placeholder="{{ __('Select Permissions') }}">
                                        <option value="" selected="selected">Please select employee permissions</option>
                                        <option value="2">HR</option>
                                        <option value="4">TL</option>
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label class="form-control-label" for="input-doj">{{ __('Date of Joining') }}</label>
                                    <input type="date" name="joining_date" id="input-doj" class="form-control" placeholder="{{ __('Date of Joining') }}" value="" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="" required>
                                    @include('alerts.feedback', ['field' => 'password'])
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm Password') }}" value="" required>
                                </div>

                                <div class="text-left" style="text-align: left !important;margin: 0 0 20px;">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
					
					<div class="card-footer p-0 card-footer card-foote22 py-2">
 <a href="{{ route('hr/employees') }}" class="btn  btn-primary1">{{ __('Back') }}</a>

                </div>
					
					
					
                </div>
            </div>
        </div>
    </div>
@endsection
