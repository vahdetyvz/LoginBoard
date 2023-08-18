<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class SchoolController extends WebController
{
	public function index() {
		if(count((array)Session::get('jwt')) > 0) {
			//$response = getAPI(['name' => 'Vahdet Koleji','auth' => 1],'POST','school/create');
			$response = getAPI('GET','getSchoolList');
			return view('school.list',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function create() {
		$yetkiler = [
			'Okullar' => false,
			'Öğretmenler' => false,
			'Adminler' => false,
			'Gruplar' => false,
			'Tahtalar' => false,
			'Duyurular' => false,
			'Tahta Tanımla' => false
		];
		$users = getAPI('GET','users');
		return view('school.create',compact('users','yetkiler'));
	}
	
	public function masterKey() {
		$users = getAPI('GET','getMasterKey');
		return view('school.masterKey',compact('users'));
	}
	
	public function masterKeySave(Request $request) {
		$users = getAPI('POST','masterKeys',['masterkey' => $request->masterkey]);
		return redirect()->back();
	}
	
	public function save(Request $request) {
		try {
			$rules = [
				'name' => 'required|string|max:255',
				'device' => 'required|string',
				'license_date' => 'required|string',
				'fullname' => 'required|string|max:255',
				'email' => 'required|string|max:255',
				'password' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
				
			if ($validator->fails()) {
				$msg = "";
				foreach(json_decode(json_encode($validator->messages())) as $item) {
					$msg .= $item[0]."<br />";
				}
				return redirect()->back()->withErrors(['msg' => $msg]);
			}
			
			$data = [
				'name' => $request->name,
				'device' => $request->device,
				'license_date' => $request->license_date,
				'fullname' => $request->fullname,
				'email' => $request->email,
				'auth' => json_encode($request->auth),
				'password' => $request->password
			];
			
			$response = getAPI('POST','school/create',$data);
			if(isset($response->return) && $response->return) {
				return redirect('/school');
			}else {
				return redirect()->back()->withErrors(['msg' => 'Bir hata meydana geldi']);
			}
		}catch(\Exception $e) {
			return redirect()->back()->withErrors(['msg' => 'Kayit işlemi başarısız.']);
		}
	}
	
	public function category() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('POST','getCategories',['lang' => 'tr']);
			return view('category.index',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function createCategory() {
		$lang = getAPI('GET','getLang');
		return view('category.create',compact('lang'));
	}
	
	public function saveCategory(Request $request) {
		$response = getAPI('POST','category/create',['name' => $request->name]);
		if($response->return) {
			return redirect('/categories');
		}
	}
	
	public function categoryEdit($id) {
		$school = getAPI('GET','getCategory/'.$id);
		$lang = getAPI('GET','getLang');
		return view('category.edit',compact('school','lang'));
	}
	
	public function categoryUpdate($id,Request $request) {
		$response = getAPI('POST','category/update/'.$id,['name' => $request->name]);
		if($response->return) {
			return redirect('/categories');
		}
	}
	
	public function getCategoryDelete($id) {
		getAPI('GET','getCategoryDelete/'.$id);
		getAPI('GET','getCategoryLangDelete/'.$id);
		return redirect('/categories');
	}
	
	public function edit($id) {
		try {
			$users = getAPI('GET','users');
			$school = getAPI('GET','getSchool/'.$id);
			return view('school.edit',compact('users','school'));
		}catch(\Exception $e) {
			return redirect()->back()->withErrors(['msg' => 'Kayit işlemi başarısız.']);
		}
	}
	
	public function update($id,Request $request) {
		try {
			$rules = [
				'name' => 'required|string|max:255',
				'auth' => 'required|integer',
				'device' => 'required|string',
				'license_date' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
				
			if ($validator->fails()) {
				$msg = "";
				foreach(json_decode(json_encode($validator->messages())) as $item) {
					$msg .= $item[0]."<br />";
				}
				return redirect()->back()->withErrors(['msg' => $msg]);
			}
			
			$response = getAPI('POST','school/edit/'.$id,['name' => $request->name,'auth' => $request->auth,'device' => $request->device,'license_date' => $request->license_date]);
			if($response->return) {
				return redirect('/school');
			}else {
				return redirect()->back()->withErrors(['msg' => 'Bir hata meydana geldi']);
			}
		}catch(\Exception $e) {
			return redirect()->back()->withErrors(['msg' => 'Kayit işlemi başarısız.']);
		}
	}
	
	public function delete($id) {
		$response = getAPI('GET','getSchoolDelete/'.$id);
		return redirect('/school');
	}
}
