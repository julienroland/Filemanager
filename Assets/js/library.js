;
(function ($) {
    var oLang,
        file = $('#file_filemanager'),
        button_file = $('#filemanager_library'),
        folder_finder = $('#folder_finder'),
        foldersName = $('.folder div.name'),
        foldersLink = $('.folder a'),
        foldersInput = $('.folder input.name'),
        folders = [],
        files = [],

        filesName = $('.file div.name'),
        filesLink = $('.file a'),
        filesInput = $('.file input.name'),
        file_finder = $('#file_finder'),
        filemanager_asset = '/filemanager/',
        folderList = $('.folder'),
        nav_link = $('#filemanager_library-popup .navigation a[data-request="create_folder"]');

    $(function () {
        getModuleTranslation();
        button_file.on('click', openFileUpload);
        nav_link.on('click', createFolder);

        foldersEvents();
        filesEvents();

        dragAndDropEvent();
        fileUpload();

    });

    var createFolder = function () {
        $.ajax({
            url: 'ajax/folder/create',
            dataType: 'json',
            data: {'name': oLang.library.folder.default_name},
            success: function (oData) {
                var folder = $(displayFolder(oData));
                console.log(folder);
                folder_finder.append(folder);
                toggleFolderDivInput(folder.find('input.name'))
                folder.find('input.name').focus();
                foldersEvents(folder);
            }
        });
    }
    var unTargetFolder = function () {
        $(this).parents('.folder').removeClass('target');
    }
    var targetFolder = function (e) {
        e.preventDefault();
        $(this).focus();
        $(this).parents('.folder').addClass('target');
        $(this).enterKey(function () {
            editFolderName($(this));
        });
    }
    var unTargetFile = function () {
        console.log('blur');
        $(this).parents('.file').removeClass('target');
    }
    var targetFile = function (e) {
        e.preventDefault();
        $(this).focus();
        $(this).parents('.file').addClass('target');
        $(this).enterKey(function () {
            editFileName($(this));
        });
    }
    var openFolder = function (e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    }
    var appendFile = function (sString) {
        file_finder.append(sString);
    }
    var appendFileIntoFolder = function (file, folder) {
        console.log('drop');
        $.ajax({
            url: 'ajax/file/' + file.attr('data-id') + '/append/folder/' + folder.attr('data-id'),
            success: function (oData) {
                console.log(oData);
            }
        })
    }
    var editFileName = function ($that) {
        if (typeof $that === "undefined") {
            var $that = $(this);
        }
        displayInputFileName($that);
    }
    var toggleFileDivInput = function ($that) {
        $that.parents('.file').find('input.name').toggleClass('hidden');
        $that.parents('.file').find('div.name').toggleClass('hidden');
        $that.parents('.file').find('input.name').not('.hidden').focus();
    }
    var displayInputFileName = function ($that) {
        toggleFileDivInput($that);
        refreshHtmlFileNameValue($that);
    }
    var refreshHtmlFileNameValue = function ($that) {
        refreshFileNameValue($that);
        $that.parents('.file').find('div.name').html($that.parent().find('input.name').val());

    }
    var toggleFolderDivInput = function ($that) {
        $that.parents('.folder').find('input.name').toggleClass('hidden');
        $that.parents('.folder').find('div.name').toggleClass('hidden');
        $that.parents('.folder').find('input.name').not('.hidden').focus();
    }
    var displayInputFolderName = function ($that) {
        refreshHtmlFolderNameValue($that);
    }
    var editFolderName = function ($that) {
        if (typeof $that === "undefined") {
            var $that = $(this);
        }
        displayInputFolderName($that)
    }
    var refreshFileNameValue = function ($that) {
        if ($that === "undefined") {
            var $that = $(this);
        }
        $that.blur();
        var data = {'name': $that.val()};
        $.ajax({
            url: 'ajax/file/update/' + $that.parents('.file').attr('data-id'),
            data: data,
            success: function (oData) {
                console.log(oData);

            }
        });
    }
    var hiddenInputAndShowName = function () {
        $(this).toggleClass('hidden');
    }
    var displayFile = function (oData) {
        if (oData !== "undefined") {
            var file = {};
            file.id = oData.id;
            file.name = oData.name;
            file.url = oData.file_variant[0].url;
            //file.fileType.icon = oData.file_type.icon;
            files.push(file);

            var file_output = '<div class="file" data-id="' + file.id + '"><div class="icon"><a href="javascript:void(0)"><img src="' + filemanager_asset + file.url + '" alt=""/></a> </div> <div class="name">' + file.name + ' </div> <input type="text" data-request="edit_file_name" class="name hidden" value="' + file.name + '"/> </div>';

            return file_output;
        }
    }
    var displayFolder = function (oData) {
        if (oData !== "undefined") {
            var folder = {};
            folder.id = oData.id;
            folder.name = oLang.library.folder.default_name;
            folder.icon = null;

            folders.push(folder);
            var folder_output = '<div class="folder" data-id="' + folder.id + '"> <div class="icon"> <a href="javascript:void(0)" data-request="open_folder"> <img src="/modules/filemanager/images/folder_icon.png" alt="' + oLang.library.Folder + '"/> </a> </div> <div class="name">' + oLang.library.folder.default_name + ' </div><input type="text" data-request="edit_folder_name" class="name hidden" value="' + oLang.library.folder.default_name + '"/> </div>';

            return folder_output;
            refreshHtmlFolderNameValue();
        }
    }
    var refreshHtmlFolderNameValue = function ($that) {
        refreshFolderNameValue($that);
        $that.parents('.folder').find('div.name').html($that.parents('.folder').find('input.name').val());
    }
    var refreshFolderNameValue = function ($that) {
        if ($that === "undefined") {
            var $that = $(this);
        }
        console.log($that.val());
        //$that.blur();
        var data = {'name': $that.val()};
        $.ajax({
            url: 'ajax/folder/update/' + $that.parents('.folder').attr('data-id'),
            data: data,
            success: function (oData) {
                console.log(oData);
            }
        });
    }
    var openFileUpload = function (e) {
        e.preventDefault();
        console.log('ok');
        file.click();
    }
    var getModuleTranslation = function () {
        $.ajax({
            url: 'ajax/getTranslation',
            dataType: 'json',
            async: false,
            success: function (oData) {
                oLang = oData;
            }
        });
    }
    var foldersEvents = function (folder) {
        if (typeof folder === "undefined") {
            foldersInput.on('change', function () {
                editFolderName($(this));

            });
            foldersInput.on('blur', function () {
                toggleFolderDivInput($(this));
            });
            foldersInput.enterKey(function () {
                toggleFolderDivInput($(this));
            });
            foldersName.on('dblclick', function () {
                toggleFolderDivInput($(this));
            });
            foldersLink.on('dblclick', openFolder);
            foldersLink.on('click', targetFolder);
            foldersLink.on('blur', unTargetFolder);
        } else {
            folder.find('input.name').on('change', function () {
                editFolderName($(this));
            });
            folder.find('input.name').on('blur', function () {
                toggleFolderDivInput($(this));
            });
            folder.find('input.name').enterKey(function () {
                toggleFolderDivInput($(this));
            });
            folder.find('div.name').on('dblclick', function () {
                editFolderName($(this));
            });
            folder.find('a').on('dblclick', openFolder);
            folder.find('a').on('click', targetFolder);
            folder.find('a').on('blur', unTargetFolder);
        }
    }
    var filesEvents = function (file) {
        if (typeof file === "undefined") {
            filesInput.on('change', function () {
                editFileName($(this));
            });
            filesName.on('dblclick', function () {
                toggleFileDivInput($(this));
            });
            filesInput.on('blur', function () {
                console.log('file blur');
                toggleFileDivInput($(this));
            });
            filesInput.enterKey(function () {
                toggleFileDivInput($(this));
            });

            filesLink.on('click', targetFile);
            filesLink.on('blur', unTargetFile);
        } else {
            console.log('file event');
            file.find('input.name').on('change', function () {
                editFileName($(this));
            });
            file.find('div.name').on('dblclick', function () {
                toggleFileDivInput($(this));
            });
            file.find('input.name').on('blur', function () {
                console.log('file blur');
                toggleFileDivInput($(this));
            });
            file.find('input.name').enterKey(function () {
                toggleFileDivInput($(this));
            });

            file.find('a').on('click', targetFile);
            file.find('a').on('blur', unTargetFile);
        }
    }
    var dragAndDropEvent = function () {
        $('.file').draggable();
        $('.folder').draggable();
        $('.folder').droppable({
            drop: function (e, ui) {
                appendFileIntoFolder(ui.draggable, $(this));
                $(this).addClass('ui-state-highlight');
            },
            over: function (e, ui) {
                console.log('Do some anims');
            }
        });
    }
    var fileUpload = function () {
        file.fileupload({
            url: 'ajax/upload',
            dataType: 'json',
            done: function (e, oData) {
                console.log(oData.result);
                //je return pas d'obj pour recup la file
                var $file = $(displayFile(oData.result));
                console.log($file);
                appendFile($file);
                toggleFileDivInput($file.find('div.name'));
                filesEvents($file);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                    'width',
                    progress + '%'
                );
            }
        });
    }
    $.fn.enterKey = function (fnc) {
        return $.each(this, function () {
            $(this).on('keydown', function (e) {
                var keycode = e.which;
                if (keycode == '13') {
                    fnc.call(this, e);
                }
            });
        })
    }
}).call(this, jQuery);