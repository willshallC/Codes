@extends('employee.layouts.emp-app', ['pageSlug' => 'update-password'])

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


    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">{{ __('Update Password') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="row col-md-12">
					<div class="card-body edit-profile">
                        <form method="post" action="{{ route('save-password') }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-3">
								<div class="form-group">
                                    <label class="form-control-label" for="input-phone_personal">{{ __('Old Password') }}</label>
									<input type="password" id="old-password" name="old_password" class="form-control form-control-alternative" placeholder="">
								</div>
								<div class="form-group">
                                    <label class="form-control-label" for="input-phone_personal">{{ __('New Password') }}</label>
                                   <input type="password" id="new-password" name="password" class="form-control form-control-alternative" placeholder="">
								</div>
								<div class="form-group">
                                    <label class="form-control-label" for="input-phone_personal">{{ __('Confirm Password') }}</label>
                                   <input type="password" id="confirm-password" name="password_confirmation" class="form-control form-control-alternative" placeholder="">
								</div>
                                <div class="text-left">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer py-4">

                </div>
            </div>
        </div>
    </div>
	<style>
	.main-panel > .content .below-content-all form .form-group .form-control-label {
    display: block !important;
	}
	</style>
@endsection
@push('js')
<script>

</script>
@endpush
