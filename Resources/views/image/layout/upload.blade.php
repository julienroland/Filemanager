@extends('filemanager::image.layout.layout')

@section('fields')

<input type="file" name="{{Config::get('filemanager::config.image_name')}}" id="image"/>

@stop