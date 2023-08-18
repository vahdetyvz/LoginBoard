<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QRController extends \App\Http\Controllers\Controller
{
    public function getQRDecrypt(Request $request) {
		try {
			$rules = [
				'qrcode' => 'required|string|max:255'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$qr = decryptQR($request->qrcode);
			
			return response()->json(['return' => $qr],200);
			
			return response()->json(['message' => 'QR Alma işlemi sırasında bir hata ile karşılaşıldı.'],400);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getQREncrypt(Request $request) {
		try {
			$rules = [
				'qrcode' => 'required|string|max:255'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			$qr = encryptQR($request->qrcode);
			
			return response()->json(['return' => $qr],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
}
