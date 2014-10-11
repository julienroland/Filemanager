@extends('filemanager::layout.layout')

@section('folders')
    @foreach($directories as $directory)
        <div class="folder" data-id="{{$directory->id}}">
        <div class="icon">
        <a href="{{route('filemanager.library',['directory'=>$directory->id])}}" data-request="open_folder">
            <img src="{{Module::asset('filemanager', 'images/folder_icon.png')}}" alt="{{trans('filemanager::library.Folder')}}"/>
         </a>
        </div>
        <div class="name">{{!is_null($directory->name) ? $directory->name : trans('filemanager::library.folder.default_name')}}
        </div>
        <input type="text" data-request="edit_folder_name" class="name hidden" value="{{!is_null($directory->name) ? $directory->name : trans('filemanager::library.folder.default_name')}}"/>
        </div>
    @endforeach
@stop

@section('files')
    @foreach($files as $file)
        <div class="file" data-id="{{$file->id}}">
        <div class="icon">
        <a href="javascript:void(0)">
        <img src="{{isset($file->fileVariant[0]) ? upload_dir($file->fileVariant[0]->url) : $file->fileType->icon}}" alt=""/>
        </a>
        </div>
        <div class="name">
        {{$file->name}}
        </div>
        <input type="text" data-request="edit_file_name" class="name hidden" value="{{$file->name}}"/>
        </div>
    @endforeach
@stop




