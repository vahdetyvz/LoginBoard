<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\Board;
use App\Models\Grup;
use App\Models\UserBoard;
use App\Models\User;
use App\Models\School;
use App\Models\Sender;
use App\Models\Announcement;
use DB;

class BoardController extends \App\Http\Controllers\Controller
{
	public function getSchoolBoardList() {
		try {
			$board = Board::where(['school_id' => auth()->user()->school_id, 'silinme' => 0])->get()->map(function ($item, $key) {
				return [
					'id' => $item->id,
					'mac_address' => $item->mac_address,
					'school_description' => $item->school_description,
					'school_id' => $item->school->name,
					'status' => $item->status,
					'grup' => $item->grup->name
				];
			});
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function debugManager(Request $request) {
		DB::table('debug')->insert(['message' => $request->message]);
	}
	
	public function onlineOfflineCount($durum) {
		try {
			if(auth()->user()->auth_id != 1) {
				$board = Board::where(['school_id' => auth()->user()->school_id,'status' => $durum, 'silinme' => 0])->get();
			}else {
				$board = Board::where(['status' => $durum, 'silinme' => 0])->get();
			}
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getBoardDurumList() {
		try {
			if(auth()->user()->auth_id != 1) {
				$board = Board::where(['school_id' => auth()->user()->school_id, 'silinme' => 1])->get();
			}else {
				$board = Board::where(['silinme' => 1])->get();
			}
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getSchoolBoardIDList($id) {
		try {
			if(@auth()->user()->auth_id == 1) {
				$user = User::find($id);
				$board = Board::where(['school_id' => $user->school_id, 'silinme' => 0])->get()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'mac_address' => $item->mac_address,
						'name' => $item->school_description
					];
				});
			}else {
				$board = Board::where(['school_id' => @auth()->user()->school_id, 'silinme' => 0])->get()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'mac_address' => $item->mac_address,
						'name' => $item->school_description
					];
				});
			}
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getSchoolIDBoardList($id) {
		try {
			if(auth()->user()->auth_id == 1) {
				if($id == 0) {
					$board = Board::all();
				}else {
					$board = Board::where(['school_id' => $id, 'silinme' => 0])->get();
				}
			}else {
				$board = Board::where(['school_id' => auth()->user()->school_id, 'silinme' => 0])->get();
			}
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getUserBoard($id) {
		try {
			$board = UserBoard::find($id);
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getBoardList() {
		try {
			if(auth()->user()->auth_id != 1) {
				if(auth()->user()->auth_id == 3) {
					$board = Board::join('user_boards','user_boards.board_id','=','boards.id')->where(['boards.school_id' => auth()->user()->school_id, 'boards.silinme' => 0, 'user_boards.user_id' => auth()->user()->id])->get()->map(function ($item, $key) {
						return [
							'id' => $item->id,
							'mac_address' => $item->mac_address,
							'school_description' => $item->school_description,
							'status' => $item->status,
							'boardDetail' => $item->boardDetail
						];
					});
				}else {
					$board = Board::where(['school_id' => auth()->user()->school_id, 'silinme' => 0])->get()->map(function ($item, $key) {
						return [
							'id' => $item->id,
							'mac_address' => $item->mac_address,
							'school_description' => $item->school_description,
							'status' => $item->status,
							'boardDetail' => $item->boardDetail
						];
					});
				}
			}else {
				$board = Board::where(['silinme' => 0])->get()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'mac_address' => $item->mac_address,
						'school_description' => $item->school_description,
						'status' => $item->status,
						'boardDetail' => $item->boardDetail,
						'school_id' => $item->school->name
					];
				});
			}
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function userboardSave(Request $request) {
		try {
			$rules = [
				'user_id' => 'required|string',
				'board_id' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$board = UserBoard::where(['user_id' => $request->user_id, 'board_id' => $request->board_id]);
			
            if($board->count() > 0) {
                return response()->json(['return' => true,'message' => 'Böyle bir tahta var.','detail' => $board],200);
            }else {
                $board = new UserBoard();
    			$board->user_id = $request->user_id;
    			$board->board_id = $request->board_id;
    			$board->save();
    			
    			return response()->json(['return' => true,'message' => 'Tahta başarı ile eklendi.','detail' => $board],200);
            }
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
    public function create(Request $request) {
		try {
			$rules = [
				'school_id' => 'required|string|max:255',
				'mac_address' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$board = Board::where(['mac_address' => $request->mac_address])->first();
            if($board != null) {
                $json = json_decode($request->boardDetail);
				$json->OutIp = $_SERVER["REMOTE_ADDR"];
				$board->boardDetail = json_encode($json);
				$board->save();
                return response()->json(['return' => true,'message' => 'Böyle bir tahta var.','detail' => $board],200);
            }else {
				$school = School::where('number',$request->school_id)->first();
				$toplamBoard = Board::where('school_id',$school->id)->count();
				if($school != null) {
					if($toplamBoard < $school->device) {
						$board = new Board();
						$board->school_id = $school->id;
						$board->mac_address = $request->mac_address;
						$json = json_decode($request->boardDetail);
						$json->OutIp = $_SERVER["REMOTE_ADDR"];
						$board->boardDetail = json_encode($json);
						$board->school_description = '';
						$board->status = 0;
						$board->grup_id = 0;
						$board->save();
						
						return response()->json(['return' => true,'message' => 'Tahta başarı ile eklendi.','detail' => $board],200);
					}else {
						return response()->json(['return' => false,'message' => 'School limit reached','detail' => $board],200);
					}
				}else {
					return response()->json(['return' => false,'message' => 'School not found'],200);
				}
            }
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getBoardStatus(Request $request) {
		try {
			$rules = [
				'mac_address' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$board = Board::where(['mac_address' => $request->mac_address])->first();
			$detail = json_decode($board->boardDetail);
			$detail->OutIp = $_SERVER["REMOTE_ADDR"];
			//print_r($detail);
			$board->boardDetail = json_encode($detail);
			$board->save();
			
			return response()->json(['status' => $board->status],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getTeacherBoardList(Request $request) {
		try {
			//$userboard = UserBoard::where('user_id',auth()->user()->id);
			$board = Board::join('user_boards','boards.id','=','user_boards.board_id')->where('user_boards.user_id',auth()->user()->id)->get();
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function hoursGroup($id) {
		try {
			$board = Grup::find($id);
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function saveHours($id,Request $request) {
		try {
			$board = Grup::find($id);
			$board->hours = $request->hours;
			$board->save();
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getTeacherBoardAllList(Request $request) {
		try {
			if(auth()->user()->auth_id != 1) {
				$board = UserBoard::join('users','users.id','=','user_boards.user_id')->where('users.school_id',auth()->user()->school_id)->get()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'mac_address' => $item->board->mac_address,
						'user' => $item->user->fullname
					];
				});
			}else {
				$board = UserBoard::all()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'mac_address' => $item->board->mac_address,
						'user' => $item->user->fullname
					];
				});

			}
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getChangeBoardStatus(Request $request) {
		try {
			$rules = [
				'mac_address' => 'required|string',
				'status' => 'required|integer'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$board = Board::where(['mac_address' => $request->mac_address])->first();
			$board->status = $request->status;
			$board->updated_at = strtotime(date('Y-m-d H:i:s').'+ 1 minute');
			$board->save();
			
			return response()->json(['return' => true,'message' => 'Guncellendi'],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getQRDecryptChangeStatus(Request $request) {
		try {
			$rules = [
				'qrcode' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$decrypt = decryptQR($request->qrcode);
			$explode = explode('|',$decrypt);
			
			$board = Board::where(['mac_address' => $explode[0]])->first();
			if($board != null) {
				$board->status = 1;
				$board->updated_at = strtotime(date('Y-m-d H:i:s').'+ 1 minute');
				$board->save();
				return response()->json(['status' => $explode[2],'password' => $explode[1]],200);
			}else {
				return response()->json(['message' => 'Boyle bir tahta bulunamadi '.$decrypt.' '.$request->qrcode.' -> '.ltrim(urldecode($request->qrcode))],400);
			}
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getGroup() {
		try {
			if(auth()->user()->auth_id != 1) {
				$grup = Grup::where('school_id',auth()->user()->school_id)->get()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'name' => $item->name,
						'hours' => $item->hours,
						'board' => $item->board
					];
				});
			}else {
				$grup = Grup::all()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'name' => $item->name,
						'hours' => $item->hours,
						'school_id' => $item->school->name,
						'board' => $item->board
					];
				});
			}
			
			return response()->json($grup,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getGroups($id) {
		try {
			$grup = Grup::find($id);
			
			return response()->json($grup,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function createGrup(Request $request) {
		try {
			$rules = [
				'name' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$grup = new Grup();
			$grup->name = $request->name;
			$grup->hours = '{"Monday":["","","","","","","","","","","","","","","","","","","",""],"Tuesday":["","","","","","","","","","","","","","","","","","","",""],"Wednesday":["","","","","","","","","","","","","","","","","","","",""],"Thursday":["","","","","","","","","","","","","","","","","","","",""],"Friday":["","","","","","","","","","","","","","","","","","","",""],"Saturday":["","","","","","","","","","","","","","","","","","","",""],"Sunday":["","","","","","","","","","","","","","","","","","","",""]}';
			if(auth()->user()->auth_id != 1) {
				$grup->school_id = auth()->user()->school_id;
			}else {
				$grup->school_id = $request->school_id;
			}
			
			$grup->save();
			
			if(@$request->board != null) {
				foreach($request->board as $board) {
					$boa = Board::find($board);
					$boa->grup_id = $grup->id;
					$boa->save();
				}
			}
			
			return response()->json('basarili',200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function updateGrup($id,Request $request) {
		try {
			$rules = [
				'name' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$grup = Grup::find($id);
			$grup->name = $request->name;
			if(auth()->user()->auth_id != 1) {
				$grup->school_id = auth()->user()->school_id;
			}else {
				$grup->school_id = $request->school_id;
			}
			
			$grup->save();
			
			$grupBoard = Board::where(['grup_id' => $grup->id])->get();
			foreach($grupBoard as $gr) {
				$ch = Board::find($gr->id);
				$ch->grup_id = 0;
				$ch->save();
			}
			
			if($request->board != null) {
				foreach($request->board as $board) {
					$boa = Board::find($board);
					$boa->grup_id = $grup->id;
					$boa->save();
				}
			}
			
			return response()->json('basarili',200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getControlBoardHours() {
		try {
			$group = Grup::all();
			foreach($group as $item) {
				if($item->hours != '') {
					$hours = json_decode($item->hours,true);
					foreach($hours[date('l')] as $hour) {
						if($hour != null && (date('H:i') >= $hour) && (date('H:i') <= date("H:i",strtotime($hour." +1 minutes")))) {
							Board::where(['grup_id' => $item->id,'status' => 1])->update(['status' => 0]);
						}
					}
				}
			}
			
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getBoard($id) {
		try {
			$board = Board::find($id);
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getSenderList() {
		try {
			$board = Sender::orderBy('id', 'DESC')->get();
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function senderDelete($id) {
		try {
			$board = Sender::find($id)->delete();
			
			return response()->json($board,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function boardUpdate($id,Request $request) {
		try {
			$rules = [
				/*'school_id' => 'required|integer',*/
				'school_description' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$grup = Board::find($id);
			$grup->school_id = $request->school_id;
			$grup->grup_id = $request->grup_id;
			$grup->school_description = $request->school_description;
			$grup->save();
			
			return response()->json('basarili',200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function delete($id) {
		$user = Board::where(['id' => $id])->update(['silinme' => 1]);
		UserBoard::where(['board_id' => $id])->delete();
		return response()->json($user,200);
	}
	
	public function geri_yuklex($id) {
		$user = Board::where(['id' => $id])->update(['silinme' => 0]);
		return response()->json($user,200);
	}
	
	public function deleteGroup($id) {
		Announcement::where(['grup_id' => $id])->delete();
		$user = Grup::find($id)->delete();
		return response()->json($user,200);
	}
	
	public function userboardDelete($id) {
		$user = UserBoard::find($id)->delete();
		return response()->json($user,200);
	}
	
	public function urunTanitimSave(Request $request) {
		$data = [];
		
		if($request->pdf1 != null && $request->pdf1 != '') {
			$data['pdf1'] = $request->pdf1;
		}
		
		if($request->pdf2 != null && $request->pdf2 != '') {
			$data['pdf2'] = $request->pdf2;
		}
		
		if($request->pdf3 != null && $request->pdf3 != '') {
			$data['pdf3'] = $request->pdf3;
		}
		
		if($request->video1 != '') {
			$data['video1'] = $request->video1;
		}
		if($request->video2 != '') {
			$data['video2'] = $request->video2;
		}
		
		if($request->video3 != '') {
			$data['video3'] = $request->video3;
		}
		
		if($request->pdf1 != '' || $request->pdf2 != '' || $request->pdf3 != '' || $request->video1 != '' || $request->video2 != '' || $request->video3 != '') {
			DB::table('urun_tanitim')->where('id', 1)->update($data);
		}		
	}
	
	public function tahtaUygulamasi(Request $request) {
		if($request->tahta_app != null && $request->tahta_app != '') {
			$data['tahta_app'] = $request->tahta_app;
			DB::table('settings')->where('id', 1)->update($data);
		}
	}
}
