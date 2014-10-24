
{!! Form::open(['route'=>'filemanager.thumb.store']) !!}

{!! Form::label('tag',trans('filemanager::form.tag')) !!}
{!! Form::text('tag',null) !!}

{!! Form::label('title',trans('filemanager::form.title')) !!}
{!! Form::text('title',null) !!}

{!! Form::label('description',trans('filemanager::form.description')) !!}
{!! Form::textarea('description',null) !!}
<h2>{{trans('filemanager::form.variants')}}</h2>

<fieldset>
<legend>{{trans('filemanager::form.resize')}}</legend>
{!! Form::label('variant[resize][width]',trans('filemanager::form.width')) !!}
{!! Form::input('number','variant[resize][width]',null,array('min'=>0)) !!}

{!! Form::label('variant[resize][height]',trans('filemanager::form.height')) !!}
{!! Form::input('number','variant[resize][height]',null,array('min'=>0)) !!}

{!! Form::label('variant[resize][ratio]',trans('filemanager::form.keep_ratio')) !!}
{!! Form::checkbox('variant[resize][ratio]',null) !!}
</fieldset>

<fieldset>
<legend>{{trans('filemanager::form.crop')}}</legend>
{!! Form::label('variant[crop][width]',trans('filemanager::form.width')) !!}
{!! Form::input('number','variant[crop][width]',null,array('min'=>0)) !!}

{!! Form::label('variant[crop][height]',trans('filemanager::form.height')) !!}
{!! Form::input('number','variant[crop][height]',null,array('min'=>0)) !!}

</fieldset>

<fieldset>

<legend>{{trans('filemanager::form.greyscale')}}</legend>

{!! Form::label('variant[greyscale]',trans('filemanager::form.greyscale')) !!}
{!! Form::checkbox('variant[greyscale]',null) !!}
</fieldset>

<fieldset>
<legend>{{trans('filemanager::form.saturation')}}</legend>

{!! Form::label('variant[saturation]',trans('filemanager::form.saturation')) !!}
{!! Form::input('number','variant[saturation]',null, array('min'=>'-100','max'=>'100')) !!}
</fieldset>

<fieldset>
<legend>{{trans('filemanager::form.blur')}}</legend>

{!! Form::label('variant[blur]',trans('filemanager::form.blur')) !!}
{!! Form::input('number','variant[blur]',null, array('min'=>'0','max'=>'100')) !!}
</fieldset>

<fieldset>
<legend>{{trans('filemanager::form.radius.intro')}}</legend>

{!! Form::label('variant[radius][radius]',trans('filemanager::form.radius.radius')) !!}
{!! Form::input('number','variant[radius][radius]',null, array('min'=>'0','max'=>'100')) !!}

{!! Form::label('variant[radius][x]',trans('filemanager::form.radius.x')) !!}
{!! Form::input('number','variant[radius][x]',null, array('min'=>'0','max'=>'100')) !!}

{!! Form::label('variant[radius][y]',trans('filemanager::form.radius.y')) !!}
{!! Form::input('number','variant[radius][y]',null, array('min'=>'0','max'=>'100')) !!}
</fieldset>

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
