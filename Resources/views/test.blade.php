@extends('core::layouts.master')

@section('content-header')
<h1>Uploads</h1>
@stop

@section('content')
{!! Form::open(['route'=>'test','files'=>true]) !!}

{{Upload::dropbox('image')}}

<input type="submit" value="{{trans('filemanager::form.upload')}}"/>


@stop