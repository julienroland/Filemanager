
<h1>Uploads</h1>

{!! Form::open(['route'=>'test','files'=>true]) !!}

{{Upload::attachImage('file_name', 'Label')}}

<input type="submit" value="{{trans('filemanager::form.upload')}}"/>

