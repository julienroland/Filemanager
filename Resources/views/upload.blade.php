@extends('filemanager::layout.layout')

@section('fields')

<input type="file" name="{{Config::get('filemanager::config.file_name')}}" id=""/>


@stop
