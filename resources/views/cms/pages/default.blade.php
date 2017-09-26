@extends('cms.templates.cms_template')

@section('page-title', 'CMS | Inner Page')

@section('content')
	Your page is <strong>{{ Request::url() }}</strong>
@endsection