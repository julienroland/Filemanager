
<h1>Uploads</h1>

{!! Form::open(['route'=>'test','files'=>true]) !!}

{!! Upload::image()->name('file_image')->label('Je suis un label')->id('file')->classes(array('je','suis','une','class')) !!}

<input type="submit" value="{{trans('filemanager::form.upload')}}"/>

