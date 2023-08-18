<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Logger;
use App\Models\School;
use App\Models\User;
use App\Models\Board;
use App\Models\Grup;
use App\Models\Setting;
use Session;
use DB;
use Illuminate\Support\Facades\Hash;

class SchoolController extends \App\Http\Controllers\Controller
{
    public function index() {
		
	}
	
	public function getSchoolList() {
		$list = School::where(['status' => 1])->select('id','name','device','number','license_date')->get()->map(function ($item, $key) {
			return [
				'id' => $item->id,
				'name' => $item->name,
				'device' => $item->device,
				'number' => $item->number,
				'board_count' => $item->board,
				'license_date' => $item->license_date
			];
		});
		return response()->json($list,200);
	}
	
	public function getSchoolDetail() {
		$list = School::where(['id' => auth()->user()->school_id])->first();
		return response()->json($list,200);
	}
	
	public function toplamLisansAdet() {
		$list = School::sum('device');
		return response()->json($list,200);
	}
	
	public function masterKeys(Request $request) {
		$list = Setting::where(['id' => 1])->update(['masterkey' => $request->masterkey]);
		return response()->json($list,200);
	}
	
	public function settingsx() {
		$list = Setting::where(['id' => 1])->first();
		return response()->json($list,200);
	}
	
	public function urunTanitimix() {
		$list = DB::table('urun_tanitim')->where(['id' => 1])->first();
		return response()->json($list,200);
	}
	
	public function getSchoolTeacher() {
		if(auth()->user()->auth_id == 1) {
			$teacher = User::where(['auth_id' => 3])->get()->map(function ($item, $key) {
				return [
					'id' => $item->id,
					'fullname' => $item->fullname,
					'board_count' => $item->board,
					'school_id' => $item->school->name
				];
			});
		}else {
			$teacher = User::where(['auth_id' => 3, 'school_id' => auth()->user()->school_id])->get()->map(function ($item, $key) {
				return [
					'id' => $item->id,
					'fullname' => $item->fullname,
					'board_count' => $item->board
				];
			});
		}
		
		return response()->json($teacher,200);
	}
	
	public function getSchool($id) {
		$list = School::find($id);
		return response()->json($list,200);
	}
	
	public function create(Request $request) {
		try {
			$rules = [
				'name' => 'required|string|max:255',
				'device' => 'required|string',
				'license_date' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}

			$school = new School();
			$school->name = $request->name;
			$school->number = rand(11111111,99999999);
			$school->device = $request->device;
			$school->license_date = $request->license_date;
			$school->status = 1;
			$school->save();
			
			$users = new User();
			$users->fullname = $request->fullname;
			$users->email = $request->email;
			$users->phone = $request->phone;
			$users->school_id = $school->id;
			$users->lang_id = 1;
			$users->auth_id = 2;
			$users->auth = $request->auth;
			$users->status = 1;
			$users->password = Hash::make($request->password);
			$users->save();
			
			$schools = School::find($school->id);
			$schools->auth = $users->id;
			$schools->save();
			
			return response()->json(['return' => true,'message' => 'Okul başarı ile eklendi.'],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function update($id,Request $request) {
		try {
			$rules = [
				'name' => 'required|string|max:255',
				'auth' => 'required|integer',
				'device' => 'required|integer',
				'license_date' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}

			$school = School::find($id);
			$school->name = $request->name;
			$school->auth = $request->auth;
			$school->device = $request->device;
			$school->license_date = $request->license_date;
			$school->save();
			
			$user = User::find($request->auth);
			$user->school_id = $school->id;
			$user->save();
			
			return response()->json(['return' => true,'message' => 'Okul başarı ile düzenlendi.'],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getSchoolDelete($id) {
		if($id != '' && $id != 0) {
			User::where('school_id',$id)->delete();
			if(Board::where('school_id',$id)->first() != null) {
				Board::where('school_id',$id)->delete();
			}
			
			if(Grup::where('school_id',$id)->first() != null) {
				Grup::where('school_id',$id)->delete();
			}
			School::where('id',$id)->delete();
			return response()->json(['return' => true,'message' => 'Okul başarı ile silindi.'],200);
		}
	}
	
	public function getTeacher() {
		$user = User::find(auth()->user()->id);
		$user->school_id = $user->school->name;
		return response()->json($user,200);
	}
}
