<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use App\Http\Models\Cats\CatLanguage;


class LanguageController extends Controller
{


    public function getLanguage(Request $request, $lang = 'es')
    {

        try {

            $langs = CatLanguage::select('acronym')->get()->pluck('acronym');
            //	$langs = $result;//['es', 'en', 'cn','fra','bra'];
            $status = false;
            foreach ($langs as $item) {
                if ($lang == $item) {
                    $status = true;
                }
            }

            if ($status) {
                $pathToFile = storage_path() . "/app/lang/" . $lang . '.json';
                return response()->download(
                    $pathToFile,
                    $lang,
                    [],
                    'inline'//attachment
                );
            } else {
                return response()->json([
                    'success' => false,
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request, $lang = 'es')
    {

        try {

            $data = $request->all();

            $date =  date('Y-m-d');

            $fileName = $date.'-'.rand(11111, 99999);

            $rename =  $lang.'_'.$fileName;

            \Storage::disk('lang')->move( $lang.'.json',  $rename.'.json');

            $fileName = $lang.'.json';

            \Storage::disk('lang')->put($fileName, json_encode($data));


            return response()->json([
                'success'  => true,
                'messaage' => 'Éxito subio el JSON a Storage'
            ], 200);



        } catch (\Exception $e) {
            return response()->json([
                'success'  => false,
                'messaage' => 'No se pudo completar la acción',
                'error'    => $e->getMessage()
            ], 500);
        }
    }

    public function saveNewLenguage(Request $request, $lang = 'es')
    {

        try {

            $data = $request->all();

            $language =  new CatLanguage;
            $language->fill($data);
            $language->save();


            $fileName = $data['acronym'].'.json';

            \Storage::disk('lang')->put($fileName, json_encode($data));

            return response()->json([
                'success'  => true,
                'messaage' => 'Éxito subio el JSON a Storage'
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'success'  => false,
                'messaage' => 'No se pudo completar la acción',
                'error'    => $e->getMessage()
            ], 500);
        }
    }

    public function deleteLenguage(Request $request, $lang = 'es')
    {

        try {

            $data = $request->all();

            $dalete = CatLanguage::where('acronym',$lang)->first();
            $dalete->delete();

            return response()->json([
                'success'  => true,
                'messaage' => 'Éxito subio el JSON a Storage'
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'success'  => false,
                'messaage' => 'No se pudo completar la acción',
                'error'    => $e->getMessage()
            ], 500);
        }
    }


    public function rollback(Request $request, $lang = 'es')
    {

        try {

            $dirs = \File::directories(storage_path(). "/app/");

            $mystring = $lang;

            foreach($dirs as $dir){
                $files = \File::files($dir);

                foreach($files as $f){
                    //var_dump($f);
                    if(ends_with($f, ['.json'])){

                        $result[] = $f->getRelativePathname();

                    }
                }
            }


            foreach($result as $r){

                $pos = strpos($r, $mystring);

                if ($pos !== false) {
                    $result2[] = $r;
                }

            }

            $endelemt = end($result2);

            if ($endelemt) {
                $pathToFile = storage_path() . "/app/lang/" . $endelemt;
                return response()->download(
                    $pathToFile,
                    $lang,
                    [],
                    'inline'//attachment
                );
            } else {
                return response()->json([
                    'success' => false,
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success'  => false,
                'messaage' => 'No se pudo completar la acción',
                'error'    => $e->getMessage()
            ], 500);
        }
    }



}
