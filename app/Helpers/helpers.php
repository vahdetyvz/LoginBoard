<?php
	use GuzzleHttp\Client;
	use Illuminate\Support\Facades\File;

	function decryptQR($qrcode) {
		$cipher = 'AES-128-ECB';
		$key = 'apltechsemkolock';
		return openssl_decrypt($qrcode, $cipher, $key);
	}
	
	function encryptQR($qrcode) {
		$cipher = 'AES-128-ECB';
		$key = 'apltechsemkolock';
		return openssl_encrypt($qrcode, $cipher, $key);
	}
	
	function getUrl() {
		return Request::url();
	}
	
	function userBoardControl($board,$user_id) {
		$board = \App\Models\UserBoard::where(['board_id' => $board, 'user_id' => $user_id])->get();
		if(count($board) > 0) {
			return true;
		}else {
			return false;
		}
	}
	
	function getUserData($school_id) {
		$board = \App\Models\User::where(['school_id' => $school_id])->take(1)->first();
		if($board != null) {
			return $board->email;
		}else {
			return '';
		}
	}
	
	function createLogger($logType) {
		$logger = new \App\Models\Logger();
		$logger->log_type = $logType;
		$logger->user_id = auth()->user()->id;
		$logger->save();
	}
	
	function getAPI($requestx = 'GET',$send,$params = []) {
		if(Session::get('jwt') != null) {
			$client = new Client();
			$res = $client->request($requestx, env('API_URL').$send, [
				'form_params' => $params,
				'headers' => [
					'Authorization' => 'Bearer '.Session::get('jwt')->access_token,
					'Accept' => 'application/json'
				]
			]);
			
			if($res->getStatusCode() == 200) {
				return json_decode($res->getBody()->getContents());
			}else {
				return ['message' => 'Bir hata meydana geldi.'];
			}
		}else {
			return ['message' => 'Oturumun suresi dolmus'];
		}
	}
	
	/*
		Logger Type
		1 Giris
	*/
	
	function tum_bosluklari_temizle($metin)
	{
		$metin = str_replace("/s+/", "", $metin);
		$metin = str_replace(" ", "", $metin);
		$metin = str_replace(" ", "", $metin);
		$metin = str_replace(" ", "", $metin);
		$metin = str_replace("/s/g", "", $metin);
		$metin = str_replace("/s+/g", "", $metin);
		$metin = trim($metin);
		return $metin;
	}
	
	function tr_gun($gun) { 
		switch ($gun) {
			case 'Monday':
				return "Pazartesi";
				break;
			case 'Tuesday':
				return "Salı";
				break;
			case 'Wednesday':
				return "Çarşamba";
				break;
			case 'Thursday':
				return "Perşembe";
				break;
			case 'Friday':
				return "Cuma";
				break;
			case 'Saturday':
				return "Cumartesi";
				break;
			case 'Sunday':
				return "Pazar";
				break;
		}
	}
	
	function getTranslationForCurrentLanguage()
	{
		$languagePath = resource_path('lang');
		$currentLanguage = app()->getLocale();
		$translation = '';

		// Kontrol edilecek dil klasörlerini alalım
		$languageFolders = File::directories($languagePath);

		foreach ($languageFolders as $languageFolder) {
			$languageCode = basename($languageFolder);
			$translation .= '<li class="nav-item" style="padding-left: 35px;"><a href="'.route('changeLanguage',['lang' => $languageCode]).'" class="nav-link" ';
			if(Cache::get('language') == $languageCode) { 
				$translation .= 'style="color:#FFBA49;"';
			}
			$translation .= '>';
			$transFilePath = $languageFolder . '/trans.php';
			if (File::exists($transFilePath)) {
				$translationx = include($transFilePath);
				$translation .= '<p>'.$translationx['lang'].'</p>';
			}
			$translation .= '</a></li>';
		}

		return $translation;
	}
	
	function HerseyiKopyala($kaynak, $hedef) {
		if ( is_dir( $kaynak ) ) {
			if (!file_exists($hedef)) { @mkdir( $hedef ); }
			$Dizin = dir( $kaynak );
			while ( FALSE !== ( $giris = $Dizin->read() ) ) {
				if ( $giris == '.' || $giris == '..' ) {
					continue;
				}
				$Giris = $kaynak . '/' . $giris;
				if ( is_dir( $Giris ) ) {
					HerseyiKopyala( $Giris, $hedef . '/' . $giris );
					continue;
				}
				copy( $Giris, $hedef . '/' . $giris );
			}
			$Dizin->close();
		}else {
			copy( $kaynak, $hedef );
		}
	}