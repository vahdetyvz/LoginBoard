<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\SendMail;

class UserController extends \App\Http\Controllers\Controller
{
	public function index() {
		echo 'index';
	}
	
	public function me()
    {
		try {
			return response()->json(auth()->user(),200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function getUser($id)
    {
		try {
			return response()->json(User::find($id),200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function getUsers() {
		try {
			$users = User::where('auth_id','!=', 3)->get();
			return response()->json($users,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getTeachers() {
		try {
			if(auth()->user()->auth_id == 1) {
				$users = User::where('auth_id', 3)->get();
			}else {
				$users = User::where(['auth_id' => 3,'school_id' => auth()->user()->school_id])->get();
			}
			return response()->json($users,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getMasterKey() {
		try {
			$users = Setting::find(1);
			return response()->json($users,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function register(Request $request)
    {
		try {
			$rules = [
				'fullname' => 'required|string|max:255',
				'email' => 'required|string|max:255',
				'password' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
		
			if(User::where(['email' => $request->email])->first() != null) {
				return response()->json(['return' => false,'message' => 'Böyle bir kullanıcı daha önce kayıt edildi.'],200);
			}else {
				$data = [
					'fullname' => $request->fullname,
					'email' => $request->email,
					'phone' => $request->phone,
					'lang_id' => 1,
					'auth_id' => $request->auth_id,
					'auth' => $request->auth,
					'status' => 1,
					'password' => Hash::make($request->password),
					'password_read' => $request->password
				];

				$user = User::insert($data);

				return response()->json($user,200);
			}
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function password(Request $request) {
		$user = User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
		return response()->json($user,200);
	}
	
	public function update($id,Request $request)
    {
		try {
			$rules = [
				'fullname' => 'required|string|max:255',
				'email' => 'required|string|max:255'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}

			$data = [
				'fullname' => $request->fullname,
				'email' => $request->email,
				'phone' => $request->phone,
				'auth_id' => $request->auth_id,
				'auth' => $request->auth,
				'lang_id' => 1,
				'status' => 1
			];
			
			if($request->password != null && $request->password != '') {
				$data['password'] = Hash::make($request->password);
				$data['password_read'] = $request->password;
			}

			$user = User::find($id)->update($data);

			return response()->json($data,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function passwordReset(Request $request) {
		$rules = [
			'password' => 'required|string|max:255'
		];

		$validator = Validator::make($request->all(), $rules);
			
		if ($validator->fails()) {
			return response()->json($validator->messages());
		}
		
		$users = User::find(auth()->user()->id);
		if($users != null) {
			$users->password = Hash::make($request->password);
			$users->password_read = $request->password;
			$users->save();
			return response()->json($users,200);
		}
		
		return response()->json(['message' => 'hata'],400);
	}
}
