{!! Form::open(['route'=>'filemanager.thumb.store']) !!}

{!! Form::label('tag',trans('filemanager::form.tag')) !!}
{!! Form::text('tag',null) !!}

{!! Form::label('title',trans('filemanager::form.title')) !!}
{!! Form::text('title',null) !!}

{!! Form::label('description',trans('filemanager::form.description')) !!}
{!! Form::textarea('description',null) !!}
<h2>{{trans('filemanager::form.variants')}}</h2>

{{dd(Upload::thumbs($thumb))}}

<?php if (isset($modules)): ?>
<fieldset>
<legend>Disponible pour quel module</legend>
<?php foreach($modules as $module): ?>
    {!! Form::label('modules['.$module.']', $module) !!}
    {!! Form::checkbox('modules['.$module.']') !!}
<?php endforeach; ?>
</fieldset>
<?php endif; ?>

{!! Form::submit(trans('filemanager::form.create_thumb')) !!}
{!! Form::close() !!}
