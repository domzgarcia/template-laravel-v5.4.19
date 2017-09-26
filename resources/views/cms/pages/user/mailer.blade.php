@extends('cms.templates.cms_template')

@section('page-title', 'IRIS | Mailer')

@section('styles')
    @parent
    <!-- Datepicker-->
    <link href="{{ asset('admin_assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin_assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs2.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin_assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin_assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Datepicker-->

    <style type="text/css">
        .clearfix {
            clear: both;
        }
        .error {
            padding: 3px;
            color: #f00;
            font-size: 12px;
        }
    </style>
@endsection

@section('content')
		<div class="portlet box purple col-lg-6 col-md-12 col-xs-12">
            <div class="portlet-title">
                <h3>Mailer Test</h3>
            </div>
            <div class="portlet-body">
				<div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-8 col-md-offset-4 col-xs-8 col-xs-offset-4">
                            <br />
                            <p>Tell us about your concern. <small> (We'll back to you within 24 - 48 hours)</small></p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-xs-12">
        			<form action="{{ url('/user/send_inquiry') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="row">
                        	<!-- Full Name -->
                            <div class="form-group">
                                <label for="fullname" class="col-xs-4 control-label">Full Name <font color="red">*</font></label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="fullname" name="fullname">
                                    @if($errors->first('fullname')) 
                                    	<label class="error" for="email">
                                    		{{ $errors->first('fullname') }}
                                    	</label>  
                                    @endif
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="col-xs-4 control-label">Email <font color="red">*</font></label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" id="email" name="email">
                                    @if($errors->first('email')) 
                                    	<label class="error" for="email">
                                    		{{ $errors->first('email') }}
                                    	</label>  
                                    @endif
                                </div>
                            </div>
                            <!-- Birthday -->
                            <div class="form-group">
                                <label for="birthday" class="col-xs-4 control-label">Birthday <font color="red">*</font></label>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" autocomplete="off" id="birthday" name="birthday" >
                                    @if($errors->first('birthday')) 
                                    	<label class="error" for="email">
                                    		{{ $errors->first('birthday') }}
                                    	</label>
                                    @endif
                                </div>
                            </div>
                            <!-- Complete Address -->
                            <div class="form-group">
                                <label for="address" class="col-xs-4 control-label">Complete Address <em>(optional)</em></label>
                                <div class="col-xs-8">
                                    <textarea class="form-control" id="address" name="address" rows="4"></textarea>
                                    @if($errors->first('address')) 
                                    	<label class="error" for="email">
                                    		{{ $errors->first('address') }}
                                    	</label> 
                                    @endif
                                </div>
                            </div>
                        	<!-- Question -->
                            <div class="form-group">
                                <label for="questions" class="col-xs-4 control-label">Questions <font color="red">*</font></label>
                                <div class="col-xs-8">
                                    <textarea class="form-control" id="questions" name="questions" rows="8"></textarea>
                                    @if($errors->first('questions')) 
                                    	<label class="error" for="email">
                                    		{{ $errors->first('questions') }}
                                    	</label>  
                                    @endif
                                </div>
                            </div>
                            <!-- Submit -->
                            <div class="form-group">
                                <div class="col-xs-offset-4 col-xs-8">
                                    <button type="submit" name="submit" class="btn btn-default btn-lg btn-block green">Send</button>
                                </div>
                            </div>
                        </div>
        			</form>
                </div>

            <div class="clearfix"></div>
            </div>
		</div><!-- .container -->
    <input type="hidden" id="send_success" value="{{ session('send_success') }}" />

@endsection


@section('scripts')
    @parent
    <script type="text/javascript" src="{{ asset('admin_assets/global/plugins/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{ asset('admin_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    
    <script type="text/javascript">
        $(window).load(function(){
            $('#birthday').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
    </script>
@endsection

