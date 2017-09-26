@extends('cms.templates.cms_template')

@section('page-title', 'IRIS | My Profile')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box purple">
				<!-- title -->
				<div class="portlet-title">
					<div class="caption">
						Account Settings
					</div>
				</div>
				<!-- body -->
				<div class="portlet-body">
					<form class="form-horizontal form-bordered" method="POST" action="{{ url('/admin/my_account/update') }}">
						{{ csrf_field() }}

						<div class="form-group">
							<label class="control-label col-md-3">Email </label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="email" readonly="true" value="<?php if(old('email')) echo old('email'); else if($user['email']) echo $user['email'];  ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Full Name <span class="font-red">*</span></label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="name" value="<?php if(old('name')) echo old('name'); else if($user['name']) echo $user['name'];  ?>">
								<span class="help-block font-red">
									@if(count($errors) > 0) {{ $errors->first('name') }} @endif
								</span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3">Password <span class="font-red">*</span></label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="password">
								<span class="help-block font-red">
									@if(count($errors) > 0) {{ $errors->first('password') }} @endif
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Confirm Password <span class="font-red">*</span></label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="cpassword">
								<span class="help-block font-red">
									@if(count($errors) > 0) {{ $errors->first('cpassword') }} @endif
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Old Password <span class="font-red">*</span></label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="opassword">
								<span class="help-block font-red">
									@if(count($errors) > 0) {{ $errors->first('opassword') }} @endif
								</span>
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<input type="Submit" class="btn purple" value="Update">
											<!-- <button type="button" class="btn default">Clear</button> -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	
	<!--flasher-->
	<input type="hidden" id="success-update" value="@if(session('success')){{session('success')}}@endif"></input>
	</div>

@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		var success_update = $("#success-update").val().trim();
		if(success_update=="1"){
			toastr['success']("", "Account has been updated!");
		}
	});
</script>
@endsection