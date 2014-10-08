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

<div class="folder_finder" id="folder_finder">
    @foreach($files as $file)
           {{$file->name}}
    @endforeach
    <div id="folder">
    <div class="icon">
    <a href="javascript:void(0)" data-request="open_folder">
    <img src="http://placehold.it/60x60" alt="{{trans('filemanager::library.Folder')}}"/>
    </a>
    </div>
    <div class="name">
    {{trans('filemanager::library.folder.default_name')}}
    </div>
    </div>
</div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php echo Module::script('filemanager','js/jquery-ui.js');?>
<?php echo Module::script('filemanager','js/ajaxUpload.js');?>
<?php echo Module::script('filemanager','js/library.js');?>
