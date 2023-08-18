<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class AuthController extends Controller
{
    public function index() {
		return view('login');
	}
	
	public function login(Request $request) {
		/*$rules = [
			'email' => 'required|string|max:255',
			'password' => 'required|string|max:255'
		];

		$validator = Validator::make($request->all(), $rules);
			
		if ($validator->fails()) {
			return response()->json($validator->messages());
		}
		
		$user = User::where(['email' => $request->email, 'password' => Hash::make($request->password), 'status' => 1])->first();
		if($user != null) {
			auth()->login($user);
			return redirect('/');
		}else {
			echo 'Boyle bir kullanici yok';
		}*/
		
		try {
			$client = new Client();
			$res = $client->request("POST", env('API_URL')."auth/login", [
				'form_params' => [
					'email' => $request->email,
					'password' => $request->password
				]
			]);
			
			if($res->getStatusCode() == 200) {
				//auth()->user(json_decode($res->getBody()->getContents()));
				//print_r(auth()->user());
				Session::put('jwt', json_decode($res->getBody()->getContents()));
				Session::put('me', getAPI('GET','me'));
				return redirect('/');
			}else if($res->getStatusCode() == 350) {
				return redirect()->back()->withErrors(['msg' => 'Lisans Süreniz Bitmiş.']);
			}else {
				return ['message' => 'Bir hata meydana geldi.'];
			}
		}catch(\Exception $e) {
			return redirect()->back()->withErrors(['msg' => 'Giriş işlemi başarısız.']);
		}
	}
	
	public function logout() {
		Session::put('jwt', null);
		Session::put('me', null);
		return redirect('/');
	}
	
	public function password() {
		return view('password');
	}
	
	public function password_reset(Request $request) {
		if($request->new_password == '') {
			return redirect()->back()->withErrors(['msg' => "Yeni şifre alanı boş bırakılamaz."]);
		}
		
		if($request->repeat_password == '') {
			return redirect()->back()->withErrors(['msg' => "Yeni şifre alanı boş bırakılamaz."]);
		}
		
		if($request->repeat_password != $request->new_password) {
			return redirect()->back()->withErrors(['msg' => "Şifreler uyuşmuyor."]);
		}
		
		$response = getAPI('POST','users/password',['password' => $request->new_password]);
		return redirect()->back();
	}
}
