<?php echo Module::style('filemanager','css/style.css'); ?>
<div id="{{Config::get('filemanager::config.library_class')}}-popup" class="{{Config::get('filemanager::config.library_class')}}-popup">

<nav class="navigation">
    <ul>
    <li>
    <a data-request="create_folder" href="javascript:void(0)">{{trans('filemanager::library.create_folder')}}</a>
    </li>
     <li>
    <a data-request="upload_file" href="javascript:void(0)">{{trans('filemanager::library.upload_file')}}</a>
    {{Upload::image()}}
    </li>
    </ul>
</nav>

<div class="folder_finder">
    @foreach($files as $file)
           {{$file->name}}
    @endforeach
</div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php echo Module::script('filemanager','js/jquery-ui.js');?>
<?php echo Module::script('filemanager','js/ajaxUpload.js');?>
<?php echo Module::script('filemanager','js/library.js');?>
