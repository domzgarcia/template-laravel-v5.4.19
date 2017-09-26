@extends('cms.templates.cms_template')

@section('page-title', 'IRIS | Admin')

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}">
	<link href="{{ asset('admin_assets/custom/custom.css') }}" rel="stylesheet" type="text/css"/>

	<style type="text/css">
		i[disabled] {
		    cursor:not-allowed;
		    color: gray;
		}
	</style>
@endsection

@section('content')

	<div class="row">
		<div class="col-md-12 col-sm-12">
			<h3 class="page-title pull-left">Admin <small> User Settings</small></h3>
			<input type="button" class="btn purple pull-right circle" id="add-user" value="Add User" />
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption">
						User Settings
					</div>
				</div>

				<div class="portlet-body">
					@if (count($errors) > 0)
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif

					<div class="table-toolbar">
						<table class="table" id="user-datatable">
							
							<thead class="">
								<tr>
									<th width="5%">
										 Actions
									</th>
									<th>
										 Email
									</th>
									<th>
										 Name
									</th>
									<th>
										 Role
									</th>
									<th>
										 Status
									</th>
									<th>
										 Date Created
									</th>
									<th>
										 Date Updated
									</th>
								</tr>
							</thead>

							<tbody>
								@foreach($users as $user)
							        <tr data-id="{{ $user->id }}">
										<td class="text-center">
											<i class="fa fa-edit cursor-pointer edit-user"></i> 
											<i class="fa fa-trash cursor-pointer delete-user"></i>
											@if($user->locked == 0)
												<i class="fa fa-unlock" disabled></i>
											@else
												<i class="fa fa-lock cursor-pointer unlock-user-modal"></i>
											@endif
										</td>
										
										<td> {{ $user->email }}</td>
										
										<td> {{ $user->name }}</td>
										
										<td>{{ $user->role->name }}</td>

										<td>
											@if($user->locked == 0)
												<span class="label label-sm label-success">
													Active 
												</span>
											@else
												<span class="label label-sm label-danger">
													Locked 
												</span>
											@endif
											
										</td>
										<td>{{ $user->created_at }}</td>
										<td>{{ $user->updated_at }}</td>
									</tr>
							    @endforeach
							</tbody>

						</table>

					<!-- end-table-toolbar -->
					</div>
				<!-- end-portlet-body -->
				</div>
			</div>
		</div>
	<!-- end-row -->
	</div>

	<div class="modal fade" id="user-settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" id="user-form-save" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" name="user-id" id="user-id" value="" />
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="row">
						<div class="col-md-11">
							<div class="form-group">
								<label class="control-label col-md-3">Email <span class="font-red">*</span></label>
								<div class="col-md-9">
									<input type="text" class="form-control" id="user-email" name="user-email" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Name <span class="font-red">*</span></label>
								<div class="col-md-9">
									<input type="text" class="form-control" id="user-name" name="user-name" value="">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Role <span class="font-red">*</span></label>
								<div class="col-md-9">
									<select type="text" class="form-control" id="user-role" name="user-role">
										@foreach($roles as $role)
											<option value="{{ $role->id }}">{{ $role->name }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Password <span class="font-red toggle-required">*</span></label>
								<div class="col-md-9">
									<input type="password" class="form-control" id="user-password" name="user-password" value="">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-3">Confirm Password <span class="font-red toggle-required">*</span></label>
								<div class="col-md-9">
									<input type="password" class="form-control" id="user-cpassword" name="user-cpassword" value="">
								</div>
							</div>

						</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn purple" id="save-user" value="Save">
						<button type="button" class="btn default" data-dismiss="modal">Close</button>
					</div>
				</form>
				
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="delete-user-confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Confirmation Message</h4>
				</div>
				<div class="modal-body">
					Are you sure you want to continue ?
				</div>
				<div class="modal-footer">
					<input type="button" class="btn red" id="destroy-user" value="Delete">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="unlock-user-confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Confirmation Message</h4>
				</div>
				<div class="modal-body">
					Are you sure you want to continue ?
				</div>
				<div class="modal-footer">
					<input type="button" class="btn green" id="unlock-user" value="Unlock">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

	<input type="hidden" id="success-create" value="@if(session('success_create')){{session('success_create')}}@endif"></input>
	<input type="hidden" id="success-update" value="@if(session('success')){{session('success')}}@endif"></input>

	<!-- container-end -->
	</div>

@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			/*
			|----------------
			| Flasher Update
			|----------------
			*/
			var success_update = $("#success-update").val()
				success_update = (success_update) ? success_update.trim() : null;
			if(success_update=="1"){
				toastr['success']("", "User has been updated!");
			}
			/*
			|----------------
			| Flasher Create
			|----------------
			*/
			var success_create = $("#success-create").val()
				success_create = (success_create) ? success_create.trim() : null;
			if(success_create=="1"){
				toastr['success']("", "User has been created!");
			}
			/*
			|-------------
			| Data Table
			|-------------
			*/
		    $("#user-datatable").dataTable({
		    	"order": [[ 5, "desc" ]],
		    	"columnDefs": [
				    { "orderable": false, "targets": [0] }
				]
		    });
		    /*
			|-------------
			| Add User
			|-------------
			*/
		    $("#add-user").click(function(){
		    	var dialog = $("#user-settings");
		    	dialog.modal();
		    	dialog.find(".modal-title").text("Add User");
		    	dialog.find("#user-form-save").attr("action","{{ url('admin/user_settings/store') }}");
		    	dialog.find(".toggle-required").show();
		    	dialog.find("#user-id").val("");
				dialog.find("#user-email").val("").attr("readonly",false);
				dialog.find("#user-name").val("");
				dialog.find("#user-role").val(1);
		    })
		    /*
			|-------------
			| Edit User
			|-------------
			*/
		    $("body").on("click",".edit-user",function(){
		    	var data_id = $(this).closest("tr").attr("data-id");
		    	var dialog = $("#user-settings");

		    	dialog.modal();

		    	Metronic.blockUI({
		            target: $("body"),
		            animate: true,
		            overlayColor: 'none'
		        });

		    	dialog.find(".modal-title").text("Edit User");

		    	dialog.find("#user-form-save").attr("action","{{ url('admin/user_settings/update') }}");
		    	
		    	dialog.find(".toggle-required").hide();

		    	$.get("/admin/user_settings/show/"+data_id,
		    		function(data){
		    			try{
		    				dialog.find("#user-id").val(data['id']);
		    				dialog.find("#user-email").val(data['email']).attr("readonly",true);
		    				dialog.find("#user-name").val(data['name']);
		    				dialog.find("#user-role").val(data['role_id']);

		    				Metronic.unblockUI($("body"));
		    			}catch(e){
		    				console.log(e)
		    			}
		    	})
		    })
		    /*
			|-------------
			| Delete User
			|-------------
			*/
		    $("body").on("click",".delete-user",function(){
		    	var data_id = $(this).closest("tr").attr("data-id");
		    	$("#delete-user-confirmation").modal();
		    	$("#destroy-user").attr("data-id", data_id);
		    })

		    $("body").on("click","#destroy-user",function(){
		    	var data_id = $(this).attr("data-id");
		    	$("#delete-user-confirmation").modal('hide');

		    	console.log( $("#site_token").val() );

		    	$.post("/admin/user_settings/destroy",
		    	{
		    			"user-id": data_id,
		    			"_token" : $("#site_token").val()
		    	},function(){
		    		toastr['success']("", "User has been deleted.");
		    		window.location.reload(true);
		    	})
		    })
		    /*
			|-------------
			| Unlock User
			|-------------
			*/
			$("body").on("click",".unlock-user-modal",function(){
		    	var data_id = $(this).closest("tr").attr("data-id");
		    	$("#unlock-user-confirmation").modal();
		    	$("#unlock-user").attr("data-id",data_id);
		    })
		    $("body").on("click","#unlock-user",function(){
		    	var data_id = $(this).attr("data-id");
		    	$("#unlock-user-confirmation").modal('hide');
		    	$.post("/admin/user_settings/unlock",
		    	{
		    			"user-id":data_id,
		    			"_token" : $("#site_token").val()
		    	},function(data){
		    		toastr['success']("", "User has been Unlocked.");
		    		window.location.reload(true);
		    	})
		    })
		
		/* end-of-js */
		});
	</script>

@endsection