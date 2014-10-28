<?php
return array(
    'module_name' => 'filemanager',
    'folder_dir' => 'filemanager',
    'file_name' => 'file_filemanager',
    'image_name' => 'image_filemanager',
    'classes_names' => 'filemanager',
    'id_names' => 'filemanager',
    'hidden_field_name' => 'type_filemanager',
    'library_class' => 'filemanager_library',
    'routes_library' => 'library',
    'file_params_directory' => 'directory',
    'thumb_config_key' => 'filemanager_thumb',
    'available_thumb' =>
        array(
            'resize' => array(
                'legend' => trans('filemanager::form.resize'),
                'form' => array(
                    'width' => array(
                        'label' => trans('filemanager::form.width'),
                        'type' => 'number',
                        'attr' => array('min' => 0)
                    ),
                    'height' => array(
                        'label' => trans('filemanager::form.height'),
                        'type' => 'number',
                        'attr' => array('min' => 0)
                    ),
                    'ratio' => array(
                        'label' => trans('filemanager::form.keep_ratio'),
                        'type' => 'checkbox',
                        'attr' => null
                    ),
                ),
            ),
            'crop' => array(
                'legend' => trans('filemanager::form.crop'),
                'form' => array(
                    'width' => array(
                        'label' => trans('filemanager::form.width'),
                        'type' => 'number',
                        'attr' => array('min' => 0)
                    ),
                    'height' => array(
                        'label' => trans('filemanager::form.height'),
                        'type' => 'number',
                        'attr' => array('min' => 0)
                    ),
                ),
            ),
            'greyscale' => array(
                'legend' => trans('filemanager::form.greyscale'),
                'form' => array(
                    'greyscale' => array(
                        'label' => trans('filemanager::form.greyscale'),
                        'type' => 'checkbox',
                        'attr' => null
                    )
                ),
            ),
            'saturation' => array(
                'legend' => trans('filemanager::form.saturation'),
                'form' => array(
                    'saturation' => array(
                        'label' => trans('filemanager::form.saturation'),
                        'type' => 'checkbox',
                        'attr' => null
                    )
                ),
            ),
            'circle' => array(
                'legend' => trans('filemanager::form.circle.intro'),
                'form' => array(
                    'radius' => array(
                        'label' => trans('filemanager::form.circle.radius'),
                        'type' => 'number',
                        'attr' => array('min' => 0)
                    ),
                    'x' =>
                        array(
                            'label' => trans('filemanager::form.circle.x'),
                            'type' => 'number',
                            'attr' => null
                        ),
                    'y' => array(
                        'label' => trans('filemanager::form.circle.y'),
                        'type' => 'number',
                        'attr' => null
                    ),
                ),
            ),
        )
);
