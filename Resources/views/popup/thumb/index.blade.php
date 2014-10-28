<a href="{{route('filemanager.thumb.create')}}">{{trans('filemanager::feature.thumb.create')}}</a>
Listing des thumbs
<table>
<?php if (isset($thumbs)): ?>
<tr>
<th>
{{trans('filemanager::form.module_name')}}
</th>
<th>
{{trans('filemanager::form.tag')}}
</th>
<th>
{{trans('filemanager::form.variants_name')}}
</th>
<th>
{{trans('filemanager::form.actions')}}
</th>
</tr>
        <tr>
    <?php foreach($thumbs as $module => $thumb): ?>
        <td>
            {{$module}}
        </td>
        <?php foreach($thumb as $tag => $variants): ?>
        <td>
            {{$tag}}
        </td>
        <td>
        <?php foreach($variants as $variant => $active): ?>
            {{$variant}}
        <?php endforeach; ?>
        </td>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <td>
     <?php foreach($thumbs as $module => $data): ?>
     <?php foreach($data as $thumb => $value): ?>

        <a href="{{route('filemanager.thumb.edit',array('module'=>$module,'thumb'=>$thumb))}}">Edit</a>
        <?php endforeach; ?>
        <?php endforeach; ?>
    </td>
        </tr>
<?php endif; ?>
</table>
