<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class UserController extends WebController
{
	public function index() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','users');
			return view('users.list',compact('response'));
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
		$schools = getAPI('GET','users');
		return view('users.create',compact('schools','yetkiler'));
	}
	
	public function save(Request $request) {
		$rules = [
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
			'fullname' => $request->fullname,
			'email' => $request->email,
			'phone' => $request->phone,
			'auth_id' => $request->auth_id,
			'auth' => json_encode($request->yetki),
			'password' => $request->password
		];
		
		$response = getAPI('POST','users/register',$data);
		if(isset($response->return) && @$response->return == false) {
			return redirect()->back()->withErrors(['msg' => $response->message]);
		}
		return redirect('/users');
	}
	
	public function edit($id) {
		$yetkiler = [
			'Okullar' => false,
			'Öğretmenler' => false,
			'Adminler' => false,
			'Gruplar' => false,
			'Duyurular' => false,
			'Tahtalar' => false,
			'Tahta Tanımla' => false
		];
		$users = getAPI('GET','getUser/'.$id);
		return view('users.edit',compact('users','yetkiler'));
	}
	
	public function update($id,Request $request) {
		$rules = [
			'fullname' => 'required|string|max:255',
			'email' => 'required|string|max:255'
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
			'fullname' => $request->fullname,
			'email' => $request->email,
			'phone' => $request->phone,
			'auth_id' => $request->auth_id,
			'auth' => json_encode($request->yetki),
			'password' => $request->password
		];
		
		$response = getAPI('POST','users/update/'.$id,$data);
		return redirect('/users');
	}
	
	public function delete($id) {
		$response = getAPI('GET','getUserDelete/'.$id);
		return redirect('/users');
	}
}
