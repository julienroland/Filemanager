;
(function ($) {
    var $file = $('#file_filemanager');
    var $button_file = $('#filemanager_library');
    $(function () {
        $button_file.on('click', openFileUpload);
        $file.fileupload({
            url: 'ajax/upload',
            dataType: 'json',
            done: function (e, oData) {
                console.log(oData);
            }
        });

    });
    var openFileUpload = function (e) {
        e.preventDefault();
        $file.click();
    }
}).call(this, jQuery);