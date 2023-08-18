<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Announcement;
use App\Models\Board;
use App\Models\Sender;

class AnnouncementsController extends \App\Http\Controllers\Controller
{
	public function getAnnouncements(Request $request) {
		try {
			if(Board::where('mac_address',$request->mac_address)->count() > 0) {
				$board = Board::where('mac_address',$request->mac_address)->first();
				//print_r($board);
				$announ = Announcement::where(['grup_id' => $board->grup_id])->get();
				
				return response()->json($announ,200);
			}else {
				return response()->json(['message' => "Boyle bir id yok"],400);
			}
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getAnnouncement($id) {
		try {
			$announ = Announcement::find($id);
			return response()->json($announ,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getAnnouncementAll(Request $request) {
		try {
			if(auth()->user()->auth_id != 1) {
				$announ = Announcement::join('grups','grups.id','=','announcements.grup_id')->select('announcements.id as id','announcements.name as name','grups.name as namex')->where(['grups.school_id' => auth()->user()->school_id])->get()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'name' => $item->name,
						'grup' => $item->namex
					];
				});
			}else {
				$announ = Announcement::all()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'name' => $item->name,
						'grup' => $item->grup->name
					];
				});
			}
			return response()->json($announ,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function announSave(Request $request) {
		try {
			$rules = [
				'name' => 'required|string',
				'grup_id' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$board = new Announcement();
    		$board->name = $request->name;
    		$board->grup_id = $request->grup_id;
    		$board->save();
    			
    		return response()->json(['return' => true,'message' => 'Duyuru başarı ile eklendi.','detail' => $board],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function announDelete($id) {
		$user = Announcement::find($id)->delete();
		return response()->json($user,200);
	}
	
	public function announUpdate($id,Request $request) {
		try {
			$rules = [
				'name' => 'required|string',
				'grup_id' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$board = Announcement::find($id);
    		$board->name = $request->name;
    		$board->grup_id = $request->grup_id;
    		$board->save();
    			
    		return response()->json(['return' => true,'message' => 'Duyuru başarı ile guncellendi.','detail' => $board],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function sender(Request $request) {
		try {
			$rules = [
				'subject' => 'required|string',
				'message' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$sender = new Sender();
			$sender->subject = $request->subject;
			$sender->message = $request->message;
			$sender->save();
			
			return response()->json($sender,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
}
