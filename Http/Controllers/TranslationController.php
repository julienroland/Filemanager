<?php  namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class TranslationController extends Controller
{

    public function all()
    {

        /**
         *
         * Array qui stockera les traductions
         *
         **/
        $langs = new Collection;

        /**
         *
         * @return array
         * Tous les fichiers de langs
         *
         **/

        $langages = File::directories(base_path() . '/Modules/Filemanager/Resources/lang/');

        /**
         *
         * Pour chaque ou récupère la [$key] du fichier de la langue en cours
         *
         **/
        foreach ($langages as $key => $langage) {

            $ex = explode('/', $langage);

            if (in_array(App::getLocale(), $ex)) {

                $pathId = $key;
            }
        }

        /**
         *
         * On chope les traductions
         * @return array [$nom-fichier => $valeur]
         *
         **/

        foreach (File::files($langages[$pathId]) as $key => $files) {

            $ex = explode('/', $files);

            $fileName = explode('.', $ex[count($ex) - 1])[0];


            $langs[$fileName] = File::getRequire($files);


        }

        /**
         *
         * @return json
         *
         **/

        return Response::json($langs, 200);


    }

    public function recursivePush($langs, $data)
    {

        foreach ($data as $file) {

            if (is_array($file)) {

                $this->recursivePush($langs, $file);
            }

            $langs->push($file);
        }

        return $langs;

    }

}