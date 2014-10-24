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
        </tr>
<?php endif; ?>
</table>
