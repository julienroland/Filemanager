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

        filesName = $('.file div.name'),
        filesLink = $('.file a'),
        files = $('.file'),
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

        fileContextMenu();

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
                dragAndDropEvent();
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
    var appendFileOrFolderIntoFolder = function (fileOrFolder, folder) {
        console.log('drop');
        console.log(fileOrFolder);
        if (fileOrFolder.hasClass('file')) {
            $.ajax({
                url: 'ajax/file/' + fileOrFolder.attr('data-id') + '/append/folder/' + folder.attr('data-id'),
                success: function (oData) {
                    console.log(oData);
                }
            });
        } else if (fileOrFolder.hasClass('folder')) {
            $.ajax({
                url: 'ajax/folder/' + fileOrFolder.attr('data-id') + '/append/folder/' + folder.attr('data-id'),
                success: function (oData) {
                    console.log(oData);
                }
            });
        }
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
    var openContextMenu = function ($that) {
        var sMenu = appendContextualMenu($that);
        filesMenuEvents($(sMenu));
    }
    var appendContextualMenu = function ($that) {
        var sMenu = outputContextualMenu($that);
        $that.append(sMenu);
        return sMenu;
    }
    var outputContextualMenu = function ($that) {
        return '<div class="filemanager_contextualMenu" data-id="' + $that.attr('data-id') + '">' +
        '<ul>' +
        '<li>' +
        '<a data-request="file_open" href="javascript:void(0)">' + oLang.library.file.menu.open + '</a>' +
        '</li>' +
        '<li>' +
        '<a data-request="file_edit" href="javascript:void(0)">' + oLang.library.file.menu.edit + '</a>' +
        '</li>' +
        '<li>' +
        '<a data-request="file_delete" href="javascript:void(0)">' + oLang.library.file.menu.delete + '</a>' +
        '</li>' +
        '</ul>' +
        '</div>';
    }
    var filesMenuEvents = function (menu) {
        console.log('ok');
        menu.find('a [data-request="file_delete"]').on('click', function () {
            deleteFile($(this));
        });
    }
    var deleteFile = function ($that) {
        console.log($that);
        $.ajax({
            url: 'ajax/file/delete/' + $that.attr('data-id'),
            dataType: 'json',
            success: function (oData) {
                console.log(oData);
                removeFileFromView($that);
            }
        });
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
    var removeFileFromView = function ($that) {
        $that.addClass('deleted').delay(1000).remove();
    }
    var folderDropAnim = function ($that) {
        $that.addClass('drop-animate').delay(1000).remove();
    }
    var dragAndDropEvent = function () {
        $('.file').draggable();
        $('.folder').draggable();
        $('.folder').droppable({
            drop: function (e, ui) {
                appendFileOrFolderIntoFolder(ui.draggable, $(this));
                removeFileFromView(ui.draggable);
                $(this).addClass('ui-state-highlight');
            },
            over: function (e, ui) {
                console.log('Do some anims');
                folderDropAnim(ui.draggable);
            }
        });
    }
    var fileContextMenu = function () {
        $.contextMenu({
            selector: '.file',
            callback: function (key, options) {
                if (key == "delete") {
                    deleteFile(this);
                }
                if (key == "edit") {
                    toggleFileDivInput(this.find('div.name'));
                }
                if (key == "info") {
                    //edit/show file informations
                }
            },
            items: {
                'link': {name: oLang.library.file.menu.link, icon: "add"},
                'info': {name: oLang.library.file.menu.infos, icon: "paste"},
                'edit': {name: oLang.library.file.menu.edit, icon: "edit"},
                'delete': {name: oLang.library.file.menu.delete, icon: "delete"}
            }
        });

        $('.file').on('click', function () {
            console.log(this);
        });
    }
    var fileUpload = function () {
        file.fileupload({
            url: 'ajax/upload',
            dataType: 'json',
            done: function (e, oData) {
                var $file = $(displayFile(oData.result));
                appendFile($file);
                toggleFileDivInput($file.find('div.name'));
                filesEvents($file);
                dragAndDropEvent();
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
    $.fn.rightClick = function (fnc) {

        return $.each(this, function () {
            $(this).on('mousedown', function (e) {
                var keycode = e.which;
                if (keycode == '3') {
                    e.preventDefault();
                    console.log('ok');

                    fnc.call(this, e);
                }
            });
        })
    }
}).call(this, jQuery);
