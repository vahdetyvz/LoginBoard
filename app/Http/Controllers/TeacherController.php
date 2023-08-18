<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\School;
use App\Models\UserImport;
use Illuminate\Support\Facades\Hash;
use Session;

class TeacherController extends WebController
{
	public function index() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','teacher');
			return view('teacher.list',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function create() {
		$schools = getAPI('GET','getSchoolList');
		$board = getAPI('GET','getSchoolIDBoardList/0');
		return view('teacher.create',compact('schools','board'));
	}
	
	public function all() {
		$schools = getAPI('GET','getSchoolList');
		return view('teacher.all',compact('schools'));
	}
	
	public function allSave(Request $request) {
		if($request->file()) {
            $file1 = $request->file('file')->storeAs('', time().'_'.$request->file->getClientOriginalName(), 'Xlsx');
			//Excel::import(new UserImport, public_path('storage/'.$file1));
			Excel::import(new class implements ToCollection, WithHeadingRow, WithChunkReading {
				public function headingRow(): int
				{
					return 1;
				}

				public function chunkSize(): int
				{
					return 1000;
				}

				public function collection(Collection $rows): void
				{
					foreach($rows as $row){
						$model = User::where('email', $row['email'])->first();

						if(!$model){
							User::create([
								'fullname' => $row['adsoyad'],
								'email' => $row['email'],
								'password' => Hash::make($row['sifre']),
								'phone' => $row['telefon'],
								'school_id' => School::where(['number' => $row['okulno']])->first()->id
							]);
						}

					}
				}
			}, $file1, ExcelType::XLSX);
		}
		
		return redirect('/teacher');
	}
	
	public function save(Request $request) {
		$rules = [
			'fullname' => 'required|string|max:255',
			'email' => 'required|string|max:255',
			'password' => 'required|string',
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
			'auth_id' => 3,
			'password' => $request->password
		];
		
		if(Session::get('jwt')->userData->auth_id != 1) {
			$data['school_id'] = Session::get('jwt')->userData->school_id;
		}else {
			$data['school_id'] = $request->school_id;
		}
		
		if($data['school_id'] == 0 || $data['school_id'] == '') {
			return redirect()->back()->withErrors(['msg' => 'Okul bilgisi boş geçilemez.']);
		}
		$data['board'] = $request->board;
		
		$response = getAPI('POST','auth/register',$data);
		//print_r($response);
		if(isset($response->return) && @$response->return == false) {
			return redirect()->back()->withErrors(['msg' => $response->message]);
		}
		return redirect('/teacher');
	}
	
	public function edit($id) {
		$schools = getAPI('GET','getSchoolList');
		$teacher = getAPI('GET','getUser/'.$id);
		$board = getAPI('GET','getSchoolIDBoardList/0');
		return view('teacher.edit',compact('schools','teacher','board'));
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
			'auth_id' => 3,
			'password' => $request->password
		];
		
		if(Session::get('jwt')->userData->auth_id != 1) {
			$data['school_id'] = Session::get('jwt')->userData->school_id;
		}else {
			$data['school_id'] = $request->school_id;
		}
		
		if($data['school_id'] == 0 || $data['school_id'] == '') {
			return redirect()->back()->withErrors(['msg' => 'Okul bilgisi boş geçilemez.']);
		}
		$data['board'] = $request->board;
		
		$response = getAPI('POST','auth/update/'.$id,$data);
		return redirect('/teacher');
	}
	
	public function delete($id) {
		$response = getAPI('GET','getUserDelete/'.$id);
		return redirect('/teacher');
	}
}
