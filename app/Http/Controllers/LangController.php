<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Cats\CatLanguage;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function getAll(Request $request)
    {
        try {

            $langs = CatLanguage::where('isActive', true)->get(['acronym']);

            return response()->json([
                'success' => true,
                'langs' => $langs
            ], 200);


        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => '',
                'errror' => $e->getMessage()

            ], 500);
        }

    }

    public function getLang(Request $request, $lang = 'es')
    {

        try {

            $lang = CatLanguage::where('acronym', $lang)->first();

            if($lang){
                $pathToFile = storage_path() . "/app/lang/" . $lang->acronym . '.json';
            }
            else{
                $pathToFile = storage_path() . '/app/lang/es.json';
            }

            return response()->download(
                $pathToFile,
                $lang,
                [],
                'inline'//attachment
            );


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {

        try {

            $data = $request->all();

            $date =  date('Y-m-d');

            $fileName = $date.'-'.rand(11111, 99999);

            $rename =  $data['acronym'].'_'.$fileName;

            $language = CatLanguage::where('acronym', $data['acronym'])->first();

            if (! $language) {
                $newLanguage = new CatLanguage();

                $newLanguage->acronym = $data['acronym'];
                $newLanguage->description = 'Nuevo Lenguaje';
                $newLanguage->save();
            }

            \Storage::disk('lang')->put($data['acronym'] . '.json', json_encode($data['data']));


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

    public function disableLang($acronym)
    {
        try {

            $lang = CatLanguage::where('acronym', $acronym)->first();

            $lang->isActive = false;
            $lang->save();

            GeneralController::saveTransactionLog(4,
                'Elimina un lenguaje con acronimo: ' . $lang->acronym);

            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la acción',
            ], 500);
        }
    }

}
