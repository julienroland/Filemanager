<?php namespace Modules\Filemanager\Repositories\ImageIntervention;

use Modules\Filemanager\Repositories\ImageManipulationRepository;

class ImageInterventionImageManipulationRepository implements ImageManipulationRepository
{

    public function resize($image, $options = array())
    {
        return $image->resize($options['width'], $options['width'], function ($constraint) use ($options) {

            if (isset($options['ratio']) && $options['ratio']) {
                $constraint->aspectRatio();
            }

            if (isset($options['upsize']) && $options['upsize']) {
                $constraint->upsize();
            }
        });


    }
}