<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserBoard;
use App\Models\Logger;
use App\Models\School;
use DB;

class AuthController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login()
    {
		try {
		    //echo Hash::make('123123');
			$credentials = request(['email', 'password']);
			$userx = User::where('email',request('email'))->first();
			if($userx->school_id != 0) {
				$school = School::find($userx->school_id);
				$tarih1 = strtotime(date('Y-m-d'));
				$tarih2 = strtotime(date('Y-m-d',strtotime($school->license_date)));
				if(($tarih2 - $tarih1) / (60*60*24) <= 0) {
					return response()->json(['msg' => 'Lisans Süreniz Bitmiş'], 350);
				}
			}

			if (!$token = auth()->claims(['fullname' => 'Suzan'])->attempt($credentials)) {
				return response()->json(['error' => 'Unauthorized'], 401);
			}
			createLogger(1);
			return $this->respondWithToken($token);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }

    public function logout()
    {
		try {
			auth()->logout();
			return response()->json(['message' => 'Successfully logged out'],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }

    public function refresh()
    {
		try {
			return $this->respondWithToken(auth()->refresh());
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }

    protected function respondWithToken($token)
    {
		try {
			return response()->json([
				'access_token' => $token,
				'token_type' => 'bearer',
				'expires_in' => auth()->factory()->getTTL() * 60,
				'userData' => auth()->user(),
				'yetkiler' => json_decode(auth()->user()->auth,true)
			]);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }

    public function payload()
    {
		try {
			return auth()->payload();
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
				'password' => 'required|string',
				'school_id' => 'required|integer'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			if(User::where(['email' => $request->email])->first() != null) {
				return response()->json(['return' => false,'message' => 'Böyle bir öğretmen daha önce kayıt edildi.'],200);
			}else {
				$user = new User();
				$user->fullname = $request->fullname;
				$user->email = $request->email;
				$user->phone = $request->phone;
				$user->school_id = $request->school_id;
				$user->auth = $request->auth;
				$user->password = Hash::make($request->password);
				$user->password_read = $request->password;
				$user->lang_id = 1;
				$user->status = 1;
				
				$user->save();
				
				if($request->board != null) {
					foreach($request->board as $board) {
						$boa = new UserBoard();
						$boa->user_id = $user->id;
						$boa->board_id = $board;
						$boa->save();
					}
				}

				return response()->json($user,200);
			}
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
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
				'school_id' => $request->school_id,
				'lang_id' => 1,
				'auth' => $request->auth,
				'status' => 1
			];
			
			if($request->password != null && $request->password != '') {
				$data['password'] = Hash::make($request->password);
				$data['password_read'] = $request->password;
			}

			$user = User::find($id)->update($data);
			$boas = UserBoard::where(['user_id' => $id])->delete();
			if($request->board != null) {
				foreach($request->board as $board) {
					$boa = new UserBoard();
					$boa->user_id = $id;
					$boa->board_id = $board;
					$boa->save();
				}
			}

			return response()->json($user,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function delete($id) {
		$user = User::find($id)->delete();
		return response()->json($user,200);
	}
}
