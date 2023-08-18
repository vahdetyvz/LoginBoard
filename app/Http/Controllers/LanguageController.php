<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Language;
use Session;

class LanguageController extends WebController
{
	public function index() {
		return view('language.index');
	}
	
	public function create() {
		return view('language.create');
	}
	
	public function store(Request $request) {
		$rules = [
			'language_name' => 'required|string|max:255',
			'language_code' => 'required|string'
		];

		$validator = Validator::make($request->all(), $rules);
				
		if ($validator->fails()) {
			$msg = "";
			foreach(json_decode(json_encode($validator->messages())) as $item) {
				$msg .= $item[0]."<br />";
			}
			return redirect()->back()->withErrors(['msg' => $msg]);
		}
		
		if($request->copy_lang != 0) {
			$klasor_yolu = resource_path('lang/' . $request->language_code);
			if (!File::isDirectory($klasor_yolu)) {
				File::makeDirectory($klasor_yolu);
			}

			$dil_dosyasi = $klasor_yolu . '/trans.php';
			if (!File::exists($dil_dosyasi)) {
				$translationx = include(resource_path('lang/' . $request->copy_lang.'/trans.php'));
				$translationx['lang'] = $request->language_name;
				$translationx['copy_lang'] = $request->copy_lang;
					
				$icerik = '<?php' . PHP_EOL . 'return ' . var_export($translationx, true) . ';' . PHP_EOL;
				File::put($dil_dosyasi, $icerik);
				
				$language = new Language();
				$language->name = $request->language_name;
				$language->code = $request->language_code;
				$language->save();
				
				return redirect()->back();
			}else {
				return redirect()->back()->withErrors(['msg' => trans('trans.var_folder')]);
			}
		}
	}
	
	public function edit($code) {
		$lang = [];
		if (File::exists(resource_path('lang/'.$code))) {
			$translationx = include(resource_path('lang/'.$code.'/trans.php'));
			$lang['name'] = $translationx['lang'];
			$lang['code'] = $code;
		}
		return view('language.edit',compact('lang'));
	}
	
	public function update(Request $request, $code) {
		$rules = [
			'language_name' => 'required|string|max:255',
			'language_code' => 'required|string'
		];

		$validator = Validator::make($request->all(), $rules);
				
		if ($validator->fails()) {
			$msg = "";
			foreach(json_decode(json_encode($validator->messages())) as $item) {
				$msg .= $item[0]."<br />";
			}
			return redirect()->back()->withErrors(['msg' => $msg]);
		}
		
		if($code != $request->language_code) {
			if (File::isDirectory(resource_path('lang/'.$code))) {
				File::moveDirectory(resource_path('lang/'.$code), resource_path('lang/'.$request->language_code));
			}
		}
		
		if (File::exists(resource_path('lang/'.$request->language_code.'/trans.php'))) {
			$translationx = include(resource_path('lang/' . $request->language_code.'/trans.php'));
			$translationx['lang'] = $request->language_name;
						
			$icerik = '<?php' . PHP_EOL . 'return ' . var_export($translationx, true) . ';' . PHP_EOL;
			File::put(resource_path('lang/'.$request->language_code.'/trans.php'), $icerik);
			
			$language = Language::where(['language' => $request->language_code])->first();
			$language->name = $request->language_name;
			$language->code = $request->language_code;
			$language->save();
			
			return redirect('/language');
		}
	}
	
	public function delete($code) {
		if (File::isDirectory(resource_path('lang/'.$code))) {
			File::deleteDirectory(resource_path('lang/'.$code));
			return redirect()->back();
		}else {
			return redirect()->back()->withErrors(['msg' => 'not_folder']);
		}
	}
	
	public function translation($code) {
		if (File::exists(resource_path('lang/'.$code.'/trans.php'))) {
			$translation = include(resource_path('lang/' . $code.'/trans.php'));
			$copy = include(resource_path('lang/' . $translation['copy_lang'] .'/trans.php'));
			
			return view('language.translation',compact('translation','copy','code'));
		}else {
			return redirect()->back()->withErrors(['msg' => 'not_folder']);
		}
	}
	
	public function translationSave(Request $request,$code) {
		if (File::exists(resource_path('lang/'.$code.'/trans.php'))) {
			$translation = include(resource_path('lang/' . $code.'/trans.php'));
			foreach($request->translation as $k => $trans) {
				$translation[$k] = $trans;
			}
			
			$icerik = '<?php' . PHP_EOL . 'return ' . var_export($translation, true) . ';' . PHP_EOL;
			File::put(resource_path('lang/'.$code.'/trans.php'), $icerik);
			return redirect()->back();
		}else {
			return redirect()->back()->withErrors(['msg' => 'not_folder']);
		}
	}
}