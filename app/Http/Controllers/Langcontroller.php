<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Cats\CatLanguage;
use Illuminate\Http\Request;

class Langcontroller extends Controller
{
    public function getAll(Request $request)
    {
        try {

            $langs = CatLanguage::get(['acronym']);

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

            $pathToFile = storage_path() . "/app/lang/" . $lang->acronym . '.json';

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


}
