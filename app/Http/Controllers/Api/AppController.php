<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\App;
use App\Models\AppLang;
use App\Models\Language;
use DB;

class AppController extends \App\Http\Controllers\Controller
{
    public function getApp(Request $request) {
        try {
			$app = DB::table('apps')->join('app_langs', 'app_langs.app_id', '=', 'apps.id')->where(['apps.id' => $request->appId,'app_langs.lang' => $request->lang])->where('apps.download','!=','0')->select('apps.id as id','apps.download as download','apps.packName','app_langs.name as name','app_langs.desc as desc','apps.images1 as images1','apps.images2 as images2','apps.images3 as images3','apps.icon as icon','apps.url as url')->orderBy('apps.download', 'DESC')->get()->map(function ($item, $key) {
				return [
					'id' => $item->id,
					'name' => $item->name,
					'desc' => $item->desc,
					'packName' => $item->packName,
					'images' => [
						'https://emkologin.com/public/storage/'.$item->images1,
						'https://emkologin.com/public/storage/'.$item->images2,
						'https://emkologin.com/public/storage/'.$item->images3
					],
					'icon' => 'https://emkologin.com/public/storage/'.$item->icon,
					'url' => 'https://emkologin.com/public/storage/'.$item->url,
					'download' => $item->download
				];
			});
			
			return response()->json($app,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function getAppEdit($id) {
        try {
			$app = DB::table('apps')->where(['id' => $id])->get();
			
			return response()->json($app,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function getAppEditLang($id) {
        try {
			$app = DB::table('app_langs')->where(['app_id' => $id])->get();
			
			return response()->json($app,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function getDownloadCount(Request $request) {
		try {
			$board = App::find($request->appId);
			$board->download = $board->download+1;
			$board->save();
			
			return response()->json(['indirilmeSayisi' => $board->download],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getControlApp(Request $request) {
		try {
		    $i = 0;
			$json = json_decode($request->json,true);
			$uygulamalar = [];
			foreach($json as $j) {
				if(App::where('packName', $j)->count() > 0) {
					$u = App::where('packName', $j)->first();
					$name = AppLang::where(['lang' => $request->lang, 'app_id' => $u->id])->first()->name;
					$u->images1 = 'https://emkologin.com/public/storage/'.$u->images1;
					$u->images2 = 'https://emkologin.com/public/storage/'.$u->images2;
					$u->images3 = 'https://emkologin.com/public/storage/'.$u->images3;
					$u->url = 'https://emkologin.com/public/storage/'.$u->url;
					$u->icon = 'https://emkologin.com/public/storage/'.$u->icon;
					$uygulamalar[$i] = $u;
					$uygulamalar[$i]['name'] = $name;
					$i++;
				}
			}
			return response()->json($uygulamalar,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
	
	public function getPopuler(Request $request) {
		try {
			$app = DB::table('apps')->join('app_langs', 'app_langs.app_id', '=', 'apps.id')->where(['app_langs.lang' => $request->lang])->where('apps.download','!=','0')->select('apps.id as id','apps.download as download','apps.packName','app_langs.name as name','app_langs.desc as desc','apps.images1 as images1','apps.images2 as images2','apps.images3 as images3','apps.icon as icon','apps.url as url')->orderBy('apps.download', 'DESC')->get()->map(function ($item, $key) {
				return [
					'id' => $item->id,
					'name' => $item->name,
					'desc' => $item->desc,
					'packName' => $item->packName,
					'images' => [
						'https://emkologin.com/public/storage/'.$item->images1,
						'https://emkologin.com/public/storage/'.$item->images2,
						'https://emkologin.com/public/storage/'.$item->images3
					],
					'icon' => 'https://emkologin.com/public/storage/'.$item->icon,
					'url' => 'https://emkologin.com/public/storage/'.$item->url,
					'download' => $item->download
				];
			});
			
			return response()->json($app,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
	}
    
    public function getApps($id,Request $request) {
        try {
			$app = DB::table('apps')
				->join('app_langs', 'app_langs.app_id', '=', 'apps.id')
				->where('apps.category_id', $id)
				->where('app_langs.lang', $request->lang)
				->select('apps.id as id','apps.packName','app_langs.name as name','apps.download as download','app_langs.desc as desc','apps.images1 as images1','apps.images2 as images2','apps.images3 as images3','apps.icon as icon','apps.url as url')
				->get()->map(function ($item, $key) {
					return [
						'id' => $item->id,
						'name' => $item->name,
						'desc' => $item->desc,
						'packName' => $item->packName,
						'images' => [
							'https://emkologin.com/public/storage/'.$item->images1,
							'https://emkologin.com/public/storage/'.$item->images2,
							'https://emkologin.com/public/storage/'.$item->images3
						],
						'icon' => 'https://emkologin.com/public/storage/'.$item->icon,
						'url' => 'https://emkologin.com/public/storage/'.$item->url,
						'download' => $item->download
					];
				});
			return response()->json($app,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
    
    public function getAllApps(Request $request) {
        try {
			$app = DB::table('apps')->join('app_langs', 'app_langs.app_id', '=', 'apps.id')->where(['app_langs.lang' => $request->lang])->select('apps.id as id','apps.download as download','apps.packName','app_langs.name as name','app_langs.desc as desc','apps.images1 as images1','apps.images2 as images2','apps.images3 as images3','apps.icon as icon','apps.url as url')->get()->map(function ($item, $key) {
				return [
					'id' => $item->id,
					'name' => $item->name,
					'desc' => $item->desc,
					'packName' => $item->packName,
					'images' => [
						'https://emkologin.com/public/storage/'.$item->images1,
						'https://emkologin.com/public/storage/'.$item->images2,
						'https://emkologin.com/public/storage/'.$item->images3
					],
					'icon' => 'https://emkologin.com/public/storage/'.$item->icon,
					'url' => 'https://emkologin.com/public/storage/'.$item->url,
					'download' => $item->download
				];
			});
			return response()->json($app,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function uygulamalarSave(Request $request) {
        try {
			$rules = [
				'url' => 'required|string|max:255',
				'images1' => 'required|string|max:255',
				'images2' => 'required|string|max:255',
				'images3' => 'required|string|max:255',
				'category_id' => 'required|string|max:255',
				'icon' => 'required|string|max:255'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}

			$school = new App();
			$school->url = $request->url;
			$school->packName = $request->packName;
			$school->images1 = $request->images1;
			$school->images2 = $request->images2;
			$school->images3 = $request->images3;
			$school->icon = $request->icon;
			$school->category_id = $request->category_id;
			$school->save();
			
			foreach(Language::all() as $lang) {
				$appLang = new AppLang();
				$appLang->app_id = $school->id;
				$appLang->name = $request->name[$lang->code];
				$appLang->desc = $request->desc[$lang->code];
				$appLang->lang = $lang->code;
				$appLang->save();
			}
			
			return response()->json(['return' => true,'message' => 'Uygulama başarı ile eklendi.'],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function uygulamalarUpdate($id,Request $request) {
        try {
			$rules = [
				'category_id' => 'required|string|max:255'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}

			$school = App::find($id);
			if($request->url != null) {
				$school->url = $request->url;
			}
			
			$school->packName = $request->packName;
			if($request->images1 != null) {
				$school->images1 = $request->images1;
			}
			
			if($request->images2 != null) {
				$school->images2 = $request->images2;
			}
			
			if($request->images3 != null) {
				$school->images3 = $request->images3;
			}
			
			if($request->icon != null) {
				$school->icon = $request->icon;
			}
			$school->category_id = $request->category_id;
			$school->save();
			
			foreach(Language::all() as $lang) {
				$appLang = AppLang::where(['app_id' => $id, 'lang' => $lang->code])->first();
				$appLang->name = $request->name[$lang->code];
				$appLang->desc = $request->desc[$lang->code];
				$appLang->save();
			}
			
			return response()->json(['return' => true,'message' => 'Uygulama başarı ile duzenlendi.'],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
    
    public function getSearchApp(Request $request) {
        try {
			$rules = [
				'name' => 'required|string'
			];

			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return response()->json($validator->messages());
			}
			
			//$category = App::join('app_langs')->orWhere('name', 'like', '%' . $request->name . '%')->where(['lang' => $request->lang])->get();
			$category = DB::table('apps')->join('app_langs', 'app_langs.app_id', '=', 'apps.id')->orWhere('app_langs.name', 'like', '%' . $request->name . '%')->where(['lang' => $request->lang])->select('apps.id as id','apps.download as download','apps.packName','app_langs.name as name','app_langs.desc as desc','apps.images1 as images1','apps.images2 as images2','apps.images3 as images3','apps.icon as icon','apps.url as url')->get()->map(function ($item, $key) {
				return [
					'id' => $item->id,
					'name' => $item->name,
					'desc' => $item->desc,
					'packName' => $item->packName,
					'images' => [
						'https://emkologin.com/public/storage/'.$item->images1,
						'https://emkologin.com/public/storage/'.$item->images2,
						'https://emkologin.com/public/storage/'.$item->images3
					],
					'icon' => 'https://emkologin.com/public/storage/'.$item->icon,
					'url' => 'https://emkologin.com/public/storage/'.$item->url,
					'download' => $item->download
				];
			});
			return response()->json($category,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
	
	public function uygulamaDelete($id) {
		if($id != '' && $id != 0) {
			App::find($id)->delete();
			return response()->json(['return' => true,'message' => 'Uygulama başarı ile silindi.'],200);
		}
	}
}