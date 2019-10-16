<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function getLanguage(Request $request)
    {
       try{
           $data = $request->all();
           $success = false;
           $pathToFile = null;
           $lang = '';
           if($data['lang'] == 1){

               $pathToFile = storage_path() . "/app/lang/en.json";
               $success = true;
               $lang = 'eng';

           }

           return response()->download(
               $pathToFile,
               $lang,
               [],
               'inline'//attachment
           );






       }catch ( \Exception $e ) {
           return response()->json( [
               'success' => false,
               'message' => $e->getMessage()
           ] );
       }
    }
}
