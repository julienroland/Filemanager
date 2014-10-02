{!! Form::open(['route'=>'filemanager.image.upload','files'=>true]) !!}

@yield('fields')

<input type="submit" value="{{trans('filemanager::form.upload')}}"/>

{!! Form::close() !!}