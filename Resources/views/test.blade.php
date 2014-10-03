@extends('core::layouts.master')

@section('content-header')
<h1>Uploads</h1>
@stop

@section('content')

{{Filemanager::upload()}}

@stop