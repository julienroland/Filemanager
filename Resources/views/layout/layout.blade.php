<style>
.bar {
           height: 18px;
           background: green;
       }</style>
<?php echo Module::style('filemanager','css/style.css'); ?>
<?php echo Module::style('filemanager','css/jquery.contextMenu.css'); ?>

<div id="{{Config::get('filemanager::config.library_class')}}-popup" class="{{Config::get('filemanager::config.library_class')}}-popup">

@include('filemanager::layout.nav')
<a href="javascript:history.back()">{{trans('filemanager::library.back')}}</a>
<a href="javascript:history.forward()">{{trans('filemanager::library.next')}}</a>
<div class="finder">
@include('filemanager::layout.breadcrumb')
<div class="folder_finder" id="folder_finder">

@yield('folders')
</div>

<div class="file_finder" id="file_finder">

@yield('files')

</div>
</div>
<a href="{{route('filemanager.create.manager')}}">{{trans('filemanager::feature.thumb.manage')}}</a>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php echo Module::script('filemanager','js/jquery-ui.js');?>
<?php echo Module::script('filemanager','js/ajaxUpload.js');?>
<?php echo Module::script('filemanager','js/library.js');?>
<?php echo Module::script('filemanager','js/jquery.contextMenu.js');?>
<?php echo Module::script('filemanager','js/jquery.ui.position.js');?>