@extends('layouts.app', ['pageSlug' => 'edit-super-admin'])

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

<?php if(isset($admin)){ ?>
	<h2 >{{ __('Edit Admin') }}</h2>
<?php }else{ ?>
	<h2 >{{ __('Add Admin') }}</h2>
<?php } ?>

<div class="container-fluid mt--7 p-0">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-body employee_managements create">
                    	<?php if(isset($admin)){ ?>
							<form method="post" action="{{ route('save-edited-admin',$admin) }}" autocomplete="off">
                            @csrf
                            @method('put')
						<?php }else{ ?>
							<form method="post" action="{{ route('save-admin') }}" autocomplete="off">
                            @csrf
						<?php } ?>
                           
                            <div class="pl-lg-0">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') ? old('name') : ($admin->name ?? '') }}" required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control" placeholder="{{ __('Email') }}" value="{{ old('email') ? old('email') : ($admin->email ?? '') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-status">{{ __('Account Status') }}</label>
                                    <select name="status" id="input-status" class="form-control form-control-alternative" placeholder="{{ __('Account Status') }}" required>
                                        <option value="" disabled="disabled" selected="selected">Please select account status</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected="selected"' : (isset($admin) && $admin->status == '1' ? 'selected="selected"' : '') }} >Enable</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected="selected"' : (isset($admin) && $admin->status == '0' ? 'selected="selected"' : '') }}>Disable</option>
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control" placeholder="{{ __('Password') }}" value="" {{ isset($admin) ? '' : 'required' }}>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}" value="" {{ isset($admin) ? '' : 'required' }}>
                                </div>

                                <div class="text-left" style="text-align: left !important;margin: 0 0 20px;">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection