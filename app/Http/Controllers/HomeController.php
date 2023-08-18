<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Session;

class HomeController extends WebController
{
	public function index() {
		if(count((array)Session::get('jwt')) > 0) {
			//print_r(getAPI(['name' => 'Vahdet Koleji','auth' => 1],'POST','school/create'));
			$toplamOkullar = getAPI('GET','getSchoolList');
			$toplamKullanici = getAPI('GET','users');
			$toplamTahtalar = getAPI('GET','getBoardList');
			$onlineTahta = getAPI('GET','onlineOfflineCount/1');
			$offlineTahta = getAPI('GET','onlineOfflineCount/0');
			if(@Session::get('jwt')->userData->auth_id == 1) {
				$getSchool = getAPI('GET','getSchoolList');
			}else {
				$getSchool = getAPI('GET','getSchoolDetail');
			}
			
			$toplamLisansAdet = getAPI('GET','toplamLisansAdet');
			return view('dashboard',compact('toplamOkullar','toplamKullanici','toplamTahtalar','onlineTahta','offlineTahta','toplamLisansAdet','getSchool'));
		}else {
			return redirect('/login');
		}
	}
	
	public function uygulamaIndirme() {
		$getSchool = getAPI('GET','settingsx');
		return view('uygulama',compact('getSchool'));
	}
	
	public function urunTanitimi() {
		$getSchool = getAPI('GET','urunTanitimix');
		return view('urunTanitim',compact('getSchool'));
	}
	
	public function changeLanguage($lang) {
		Cache::forever('language', $lang);
		return Redirect::back();
	}
}
