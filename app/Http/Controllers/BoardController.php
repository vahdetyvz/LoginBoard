<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class BoardController extends WebController
{
	public function index() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getBoardList');
			//print_r($response);
			return view('board.list',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function boardRemove() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getBoardDurumList');
			return view('board.silinmis',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function getSendersList() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getSenderList');
			return view('board.sender',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function uygulamalar() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('POST','uygulamalar',['lang' => 'tr']);
			//print_r($response);
			return view('apps.index',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function getSchoolIDBoardLists($id) {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getSchoolIDBoardList/'.$id);
			return response()->json($response,200);
		}else {
			return redirect('/login');
		}
	}
	
	public function getSchoolBoardIDListx($id) {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getSchoolBoardIDList/'.$id);
			return response()->json($response,200);
		}else {
			return redirect('/login');
		}
	}
	
	public function uygulamalarEdit($id) {
		if(count((array)Session::get('jwt')) > 0) {
			$lang = getAPI('GET','getLang');
			$category = getAPI('POST','getCategories',['lang' => 'tr']);
			$detailApp = getAPI('GET','getAppEdit/'.$id);
			$detailAppLang = getAPI('GET','getAppEditLang/'.$id);
			//print_r($detailAppLang);
			$detailApp = $detailApp[0];
			return view('apps.edit',compact('category','detailApp','detailAppLang','lang'));
		}else {
			return redirect('/login');
		}
	}
	
	public function uygulamalarUpdate($id,Request $request) {
		$rules = [
			'category_id' => 'required|string',
		];

		$validator = Validator::make($request->all(), $rules);
			
		if ($validator->fails()) {
			$msg = "";
			foreach(json_decode(json_encode($validator->messages())) as $item) {
				$msg .= $item[0]."<br />";
			}
			return redirect()->back()->withErrors(['msg' => $msg]);
		}
		
		$apps = "";
		$image1 = "";
		$image2 = "";
		$image3 = "";
		$icon = "";
		
		if($request->file()) {
			if($request->file('app') != null) {
				$apps = $request->file('app')->storeAs('uploads', time().'_'.$request->app->getClientOriginalName(), 'public');
			}
			
			if($request->file('file1') != null) {
				$image1 = $request->file('file1')->storeAs('uploads', time().'_'.$request->file1->getClientOriginalName(), 'public');
			}
			
			if($request->file('file2') != null) {
				$image2 = $request->file('file2')->storeAs('uploads', time().'_'.$request->file2->getClientOriginalName(), 'public');
			}
			
			if($request->file('file3') != null) {
				$image3 = $request->file('file3')->storeAs('uploads', time().'_'.$request->file3->getClientOriginalName(), 'public');
			}
			
			if($request->file('icon') != null) {
				$icon = $request->file('icon')->storeAs('uploads', time().'_'.$request->file1->getClientOriginalName(), 'public');
			}
		}
		
		$data = [
			'name' => $request->name,
			'packName' => $request->packName,
			'desc' => $request->desc,
			'category_id' => $request->category_id
		];
		
		if(@$apps != "") {
			$data['url'] = $apps;
		}
		
		if(@$image1 != "") {
			$data['images1'] = $image1;
		}
		
		if(@$image2 != "") {
			$data['images2'] = $image2;
		}
		
		if(@$image3 != "") {
			$data['images3'] = $image3;
		}
		
		if(@$icon != "") {
			$data['icon'] = $icon;
		}
		
		//print_r($data);
		$response = getAPI('POST','uygulamalar/update/'.$id,$data);
		return redirect('/uygulamalar');
	}
	
	public function uygulamalarCreate() {
		if(count((array)Session::get('jwt')) > 0) {
			$lang = getAPI('GET','getLang');
			//print_r($lang);
			$category = getAPI('POST','getCategories',['lang' => 'tr']);
			return view('apps.create',compact('category','lang'));
		}else {
			return redirect('/login');
		}
	}
	
	public function uygulamalarSave(Request $request) {
		$rules = [
			'category_id' => 'required|string',
		];

		$validator = Validator::make($request->all(), $rules);
			
		if ($validator->fails()) {
			$msg = "";
			foreach(json_decode(json_encode($validator->messages())) as $item) {
				$msg .= $item[0]."<br />";
			}
			return redirect()->back()->withErrors(['msg' => $msg]);
		}
		if($request->file()) {
            $apps = $request->file('app')->storeAs('uploads', time().'_'.$request->app->getClientOriginalName(), 'public');
            $image1 = $request->file('file1')->storeAs('uploads', time().'_'.$request->file1->getClientOriginalName(), 'public');
            $image2 = $request->file('file2')->storeAs('uploads', time().'_'.$request->file2->getClientOriginalName(), 'public');
            $image3 = $request->file('file3')->storeAs('uploads', time().'_'.$request->file3->getClientOriginalName(), 'public');
            $icon = $request->file('icon')->storeAs('uploads', time().'_'.$request->icon->getClientOriginalName(), 'public');
		}
		
		$data = [
			'name' => $request->name,
			'packName' => $request->packName,
			'url' => $apps,
			'desc' => $request->desc,
			'images1' => $image1,
			'images2' => $image2,
			'images3' => $image3,
			'category_id' => $request->category_id,
			'icon' => $icon
		];
		//print_r($data);
		$response = getAPI('POST','uygulamalar/save',$data);
		return redirect('/uygulamalar');
	}
	
	public function announ() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getAnnouncementAll');
			//print_r($response);
			return view('announ.list',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function announCreate() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getGroup');
			return view('announ.create',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function announSave(Request $request) {
		$rules = [
			'name' => 'required|string',
			'grup_id' => 'required|string'
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
			'grup_id' => $request->grup_id,
		];
		
		$response = getAPI('POST','announSave',$data);
		return redirect('/announ');
	}
	
	public function announEdit($id) {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getGroup');
			$announ = getAPI('GET','getAnnouncement/'.$id);
			return view('announ.edit',compact('response','announ'));
		}else {
			return redirect('/login');
		}
	}
	
	public function announUpdate($id,Request $request) {
		$rules = [
			'name' => 'required|string',
			'grup_id' => 'required|string'
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
			'grup_id' => $request->grup_id,
		];
		
		$response = getAPI('POST','announUpdate/'.$id,$data);
		return redirect('/announ');
	}
	
	public function getTeacherBoard() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getTeacherBoardAllList');
			//print_r($response);
			return view('board.getTeacherBoard',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function userboardCreate() {
		if(count((array)Session::get('jwt')) > 0) {
			$teachers = getAPI('GET','getTeachers');
			return view('board.userboardCreate',compact('teachers'));
		}else {
			return redirect('/login');
		}
	}
	
	public function userboardSave(Request $request) {
		$rules = [
			'user_id' => 'required|string',
			'board_id' => 'required|string'
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
			'user_id' => $request->user_id,
			'board_id' => $request->board_id,
		];
		
		$response = getAPI('POST','userboardSave',$data);
		return redirect('/teacherBoards');
	}
	
	public function userboardEdit($id) {
		if(count((array)Session::get('jwt')) > 0) {
			$userboard = getAPI('GET','getUserBoard/'.$id);
			$board = getAPI('GET','getSchoolBoardIDList/'.$userboard->user_id);
			$teachers = getAPI('GET','getTeachers');
			return view('board.userboardEdit',compact('teachers','userboard','board'));
		}else {
			return redirect('/login');
		}
	}
	
	public function userboardUpdate($id,Request $request) {
		$rules = [
			'user_id' => 'required|string',
			'board_id' => 'required|string'
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
			'user_id' => $request->user_id,
			'board_id' => $request->board_id,
		];
		
		$response = getAPI('POST','userboardUpdate/'.$id,$data);
		return redirect('/teacherBoards');
	}
	
	public function getGroup() {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','getGroup');
			return view('board.group',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function hoursGroup($id) {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('GET','hoursGroup/'.$id);
			return view('board.group_hours',compact('response'));
		}else {
			return redirect('/login');
		}
	}
	
	public function kaydetSaat(Request $request) {
		if(count((array)Session::get('jwt')) > 0) {
			$response = getAPI('POST','saveHours/'.$request->id,['hours' => json_encode($request->hours)]);
			return redirect()->back();
		}else {
			return redirect('/login');
		}
	}
	
	public function createGroup() {
		if(count((array)Session::get('jwt')) > 0) {
			$schools = getAPI('GET','getSchoolList');
			$board = getAPI('GET','getSchoolIDBoardList/0');
			return view('board.create_group',compact('schools','board'));
		}else {
			return redirect('/login');
		}
	}
	
	public function saveGroup(Request $request) {
		$rules = [
			'name' => 'required|string|max:255'
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
			'hours' => $request->hours,
			'board' => $request->board
		];
		
		if(Session::get('me')->auth_id == 1) {
			$data['school_id'] = $request->school_id;
		}else {
			$data['school_id'] = Session::get('me')->school_id;
		}
		
		$response = getAPI('POST','createGroup',$data);
		return redirect('/group');
	}
	
	public function editGroup($id) {
		if(count((array)Session::get('jwt')) > 0) {
			$group = getAPI('GET','getGroups/'.$id);
			$schools = getAPI('GET','getSchoolList');
			$board = getAPI('GET','getSchoolIDBoardList/0');
			return view('board.edit_group',compact('schools','group','board'));
		}else {
			return redirect('/login');
		}
	}
	
	public function updateGroup($id,Request $request) {
		$rules = [
			'name' => 'required|string|max:255'
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
			'hours' => $request->hours,
			'school_id' => @$request->school_id,
			'board' => @$request->board,
		];
		
		$response = getAPI('POST','updateGrup/'.$id,$data);
		return redirect('/group');
	}
	
	public function deleteGroup($id) {
		if(count((array)Session::get('jwt')) > 0) {
			$group = getAPI('GET','deleteGroup/'.$id);
			return redirect('/group');
		}else {
			return redirect('/login');
		}
	}
	
	public function create() {
		$schools = getAPI('GET','getSchoolList');
		return view('teacher.create',compact('schools'));
	}
	
	public function save(Request $request) {
		$rules = [
			'fullname' => 'required|string|max:255',
			'email' => 'required|string|max:255',
			'auth_id' => 'required|integer',
			'phone' => 'required|string',
			'password' => 'required|string',
			'school_id' => 'required|string'
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
			'school_id' => $request->school_id,
			'auth_id' => $request->auth_id,
			'password' => $request->password
		];
		
		$response = getAPI('POST','auth/register',$data);
		return redirect('/');
	}
	
	public function edit($id) {
		$board = getAPI('GET','getBoard/'.$id);
		$schools = getAPI('GET','getSchoolList');
		$grup = getAPI('GET','getGroup');
		return view('board.edit',compact('board','schools','grup'));
	}
	
	public function update($id,Request $request) {
		$rules = [
			'school_description' => 'required|string'
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
			'school_description' => $request->school_description,
			'grup_id' => $request->grup_id
		];
		
		if(Session::get('jwt')->userData->auth_id != 1) {
			$data['school_id'] = Session::get('jwt')->userData->school_id;
		}else {
			$data['school_id'] = $request->school_id;
		}
		
		$response = getAPI('POST','boardUpdate/'.$id,$data);
		return redirect('/board');
	}
	
	public function delete($id) {
		$response = getAPI('GET','getBoardDelete/'.$id);
		return redirect('/board');
	}
	
	public function geri_yukle($id) {
		$response = getAPI('GET','geri_yuklex/'.$id);
		return redirect('/board');
	}
	
	public function userboardDelete($id) {
		$response = getAPI('GET','userboardDelete/'.$id);
		return redirect('/teacherBoards');
	}
	
	public function announDelete($id) {
		$response = getAPI('GET','announDelete/'.$id);
		return redirect('/announ');
	}
	
	public function uygulamalarDelete($id) {
		$response = getAPI('GET','uygulamalar/delete/'.$id);
		return redirect('/uygulamalar');
	}
	
	public function senderDelete($id) {
		$response = getAPI('GET','senderDelete/'.$id);
		return redirect('/sender/list');
	}
	
	public function tahtauygulamasi(Request $request) {
		$file1 = '';
		if($request->file()) {
            $file1 = $request->file('file1')->storeAs('uploads', time().'_'.$request->file1->getClientOriginalName(), 'public');
		}
		
		$data['tahta_app'] = $file1;
		$response = getAPI('POST','tahtaUygulamasi',$data);
		return redirect('/uygulamaIndirme');
	}
	
	public function urunTanitimiKaydet(Request $request) {
		$pdf1 = '';
		$pdf2 = '';
		$pdf3 = '';
		if($request->file()) {
            $pdf1 = $request->file('pdf1')->storeAs('uploads', time().'_'.$request->pdf1->getClientOriginalName(), 'public');
            $pdf2 = $request->file('pdf2')->storeAs('uploads', time().'_'.$request->pdf2->getClientOriginalName(), 'public');
            $pdf3 = $request->file('pdf3')->storeAs('uploads', time().'_'.$request->pdf3->getClientOriginalName(), 'public');
		}
		
		$data = [
			'pdf1' => $pdf1,
			'pdf2' => $pdf2,
			'pdf3' => $pdf3,
			'video1' => $request->video1,
			'video2' => $request->video2,
			'video3' => $request->video3
		];
		
		$response = getAPI('POST','urunTanitimiSave',$data);
		return redirect('/urunTanitimi');
	}
}
