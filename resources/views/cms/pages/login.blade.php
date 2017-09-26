@extends('cms.templates.cms_template')

@section('page-title', 'CMS | Login')

@section('styles')
	<link href="{{ asset('admin_assets/admin/pages/css/login.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('admin_assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('admin_assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('admin_assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('admin_assets/admin/layout/css/themes/darkblue.css') }}" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="{{ asset('admin_assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>
@endsection


@section('content')

	<div class="container">

	        <div class="login col-md-6 col-md-offset-3">

	            <div class="content">
	            
	                <h3 class="form-title font-green">Sign In</h3>

	                    <form role="form" method="POST" action="{{ route('login') }}">

	                        {{ csrf_field() }}

	                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	                            	<label for="email" class="control-label">E-Mail Address</label>

	                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

	                                @if ($errors->has('email'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('email') }}</strong>
	                                    </span>
	                                @endif
	                        </div>

	                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            	<label for="password" class="control-label">Password</label>

                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
	                        </div>

                            <div class="form-group checkbox text-center" style="vertical-align: top;">
                                <label style="vertical-align: top;">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <small>Remember Me &nbsp;&nbsp;|</small>
                                </label>
                                <a class="" href="{{ route('password.request') }}" style="vertical-align: top; margin-left: 10px;"> 
                                    <small>Forgot Your Password?</small>
                                </a>
                            </div>

                            <br />
                            
                            <div class="form-group">
	                            <button type="submit" class="btn-block btn btn-success">LOGIN</button>
                            </div>

	                    </form>

	            </div>

	        </div>
	</div>


@endsection