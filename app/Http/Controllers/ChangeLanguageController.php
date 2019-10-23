<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Language\CatLanguage;
use App\User;


class ChangeLanguageController extends Controller
{
	public function set($lang= 'es', Request $request)
	{
		try {
		
			if(isset(\Auth::user()->id)){
				$user_id =  \Auth::user()->id;
				$user = User::find($user_id);
				$user->langDefault = $lang;
				$user->save();
			}

			$langs = CatLanguage::select('acronym')->get()->pluck('acronym');
			$status = false;
			foreach ($langs as $item) {
				if ($lang == $item) {
					$status = true;
				}
			}

			if($status){
				$request->session()->put('lang', $lang);
				\App::setLocale($lang);

				$message = \Lang::get('custom.incorrect_password');

				return response()->json([
					'success' => true,
					'data' => '',
					'message' => $request->session()->get('lang'),
					'test' => $message
				], 200);
			} else {
				return response()->json([
					'success' => false,
				], 404);
			}


		} catch (\Exception $e) {

			return response()->json([
				'success' => false,
				'message' => '',
				'errror' => $e->getMessage()
			], 500);
		}

	}

	public function get(Request $request)
	{
		try {

			$lang = \App::getLocale();
			if (Session::has('lang')) {
				if (!empty(Session::get('lang'))) {
					$lang = Session::get('lang');
				}
			}

			return response()->json([
				'success' => true,
				'lang' => $lang
			], 200);


		} catch (\Exception $e) {

			return response()->json([
				'success' => false,
				'message' => '',
				'errror' => $e->getMessage()

			], 500);
		}

	}

	public function getAll(Request $request)
	{
		try {

			$lang = CatLanguage::select('acronym')->get();

			return response()->json([
				'success' => true,
				'lang' => $lang
			], 200);


		} catch (\Exception $e) {

			return response()->json([
				'success' => false,
				'message' => '',
				'errror' => $e->getMessage()

			], 500);
		}

	}

	public function showFileLang(Request $request, $lang = 'es')
	{
		try {
			$langs = CatLanguage::select('acronym')->get()->pluck('acronym');
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


}
