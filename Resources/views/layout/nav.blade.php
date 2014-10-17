<nav class="navigation">
    <ul>
    <li>
    <a data-request="create_folder" href="javascript:void(0)">{{trans('filemanager::library.create_folder')}}</a>
    </li>
     <li>
    <a data-request="upload_file" href="javascript:void(0)">{{trans('filemanager::library.upload_file')}}</a>
    {{Upload::images(Input::all())}}
    <div id="progress">
        <div class="bar" style="width: 0%;"></div>
    </div>


    </li>
    </ul>
</nav>
