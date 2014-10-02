{!! Form::open(['route'=>'filemanager.ajax.upload','files'=>true,'data-request'=>'ajax']) !!}

@yield('fields')

<input type="submit" value="{{trans('filemanager::form.upload')}}"/>

{!! Form::close() !!}