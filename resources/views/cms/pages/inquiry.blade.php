@extends('cms.templates.cms_template')

@section('page-title', 'IRIS | Inquiry')

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}">
		
	<link href="{{ asset('admin_assets/custom/custom.css') }}" rel="stylesheet" type="text/css"/> <!--pointer-->

	<style type="text/css">
		i[disabled] {
		    cursor:not-allowed;
		    color: gray;
		}
	</style>

@endsection

@section('content')
	<!-- Portlet -->
	<div class="portlet box purple col-lg-6 col-md-12 col-xs-12">
        <div class="portlet-title">
            <h3>Inquiries</h3>
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
		
			<table class="table" id="inquiries-datatable">
				<thead>
					<tr>
						<th style="width: 60px !important; ">Actions</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Birthdate</th>
						<th>Date Created</th>
					</tr>
				</thead>
			</table>

        <div class="clearfix"></div>
        </div>
	</div><!-- .container -->

	<!-- Reply -->
	<div class="modal fade" id="mail-inquiry-reply-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal form-bordered" action="{{ url('/admin/ask_belo/mail_inquiry_reply') }}" enctype="multipart/form-data"  method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" name="mail-inquiry-id" id="mail-inquiry-id" value="" />
					<input type="hidden" name="mail-inquiry-email" id="mail-inquiry-email" value="" />
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Inquiry Response</h4>
					</div>
					<div class="row">
						<div class="col-md-10">
							<div class="form-group">
								<label class="control-label col-md-3">Title <span class="font-red">*</span></label>
								<div class="col-md-9">
									<input type="text" class="form-control" id="mail-inquiry-title" name="mail-inquiry-title" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Body <span class="font-red">*</span></label>
								<div class="col-md-9">
									<textarea style="height: 100px" class="form-control" id="mail-inquiry-body" name="mail-inquiry-body"> CKEDITOR Default Body Content </textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn purple" value="Send" id="mail-inquiry-response">
						<button type="button" class="btn default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin_assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>

	<!-- ckeditor -->
	<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('/ckeditor/config.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			/*
			|-------------
			| CKEDITOR
			|-------------
			*/
			CKEDITOR.replace( 'mail-inquiry-body', toolbar_group);
			/*
			|-------------
			| Data Table
			|-------------
			*/
			$('#inquiries-datatable').DataTable({
			    processing: false,
			    serverSide: true,
			    "order": [[ 4, "desc" ]],
				"columnDefs": [
				    { "orderable": false, "targets": [0] }
				],
			    ajax: {
			    	url : '{{ url("/admin/inquiry/inbox") }}',
			    	data : function(res){
			    		console.log(res);
			    		Metronic.blockUI({
							target: $('#inquiries-datatable'),
							animate: true,
							overlayColor: 'none'
						});
			    	}
			    },
			    columns: [
			        { 
			        	data: 'id', 
			        	name: 'id',
			        	render: function ( data, type, full, meta ) {
					      	return '<a data-id="'+ full.id +'" class="fa fa-eye view-mail-inquiry"></a>' + '&nbsp;' +
									'<a data-id="'+ full.id +'" class="fa fa-mail-reply mail-inquiry-reply"></a>' + '&nbsp;&nbsp;' +
									'<a data-id="'+ full.id +'" class="fa fa-envelope view-mail-inquiry-thread"></a>';
					    }
			        },
			        { data: 'full_name', name: 'full_name' },
			        { data: 'email', name: 'email' , 'class' : 'mail-inquiry-email'},
			        { data: 'birthdate', name: 'birthdate', type:'date' },
			        { data: 'updated_at', name: 'updated_at', type:'date' }
			    ],
			    drawCallback : function(){
			    	Metronic.unblockUI($('#inquiries-datatable'))
			    }
			});
			/*
			|-------------
			| Data Table
			|-------------
			*/
			$("body").on("click",".mail-inquiry-reply",function(){
		    	var data_id = $(this).attr("data-id");
		    	var inquirer_email = $(this).closest("tr").find(".mail-inquiry-email").text().trim();
		    	$("#mail-inquiry-id").val(data_id)
		    	$("#mail-inquiry-email").val(inquirer_email);
		    	$("#mail-inquiry-reply-modal").modal();
		    });

		});
	</script>
@endsection

