<style>
.bar {
           height: 18px;
           background: green;
       }</style>
<?php echo Module::style('filemanager','css/style.css'); ?>

<div id="{{Config::get('filemanager::config.library_class')}}-popup" class="{{Config::get('filemanager::config.library_class')}}-popup">

@include('filemanager::layout.nav')

<div class="finder">
<div class="folder_finder" id="folder_finder">

@yield('folders')
</div>

<div class="file_finder" id="file_finder">

@yield('files')

</div>
</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php echo Module::script('filemanager','js/jquery-ui.js');?>
<?php echo Module::script('filemanager','js/ajaxUpload.js');?>
<?php echo Module::script('filemanager','js/library.js');?>