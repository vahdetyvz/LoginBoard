<?php
	use GuzzleHttp\Client;
	
	function getAPI($params,$request = 'GET',$send) {
		$client = new Client();
        $res = $client->request($request, env('API_URL').$send, [
            'form_params' => $params
        ],
		'headers' => [
			'Authorization' => 'Bearer '.Session::get('jwt')->access_token,
			'Accept' => 'application/json',
		]);
        
		if($res->getStatusCode() == 200) {
			return json_decode($res->getBody()->getContents());
		}else {
			return ['message' => 'Bir hata meydana geldi.'];
		}
	}
	
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