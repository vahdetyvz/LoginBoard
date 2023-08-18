<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\CategoryLang;
use App\Models\Language;
use DB;

class CategoryController extends \App\Http\Controllers\Controller
{
    public function getCategories(Request $request) {
        try {
			$categories = DB::table('categories')
				->select('categories.id as id','category_langs.name as name')
				->join('category_langs', 'category_langs.category_id', '=', 'categories.id')
				->where('category_langs.lang', $request->lang)
				->get();
			return response()->json($categories,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
    
    public function getCategory($id) {
        try {
            $categoryL = CategoryLang::where(['category_id' => $id])->get();
			return response()->json($categoryL,200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
    
    public function create(Request $request) {
        try {
			//print_r($request->all());
			$category = new Category();
			$category->save();
			
			$lang = Language::all();
			foreach($lang as $l) {
				$categoryL = new CategoryLang();
				$categoryL->category_id = $category->id;
				$categoryL->name = $request->name[$l->code];
				$categoryL->lang = $l->code;
				$categoryL->save();
			}
			
			return response()->json(['return' => true,'message' => 'Kategori başarı ile eklendi.'],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
    
    public function update($id,Request $request) {
        try {
			$lang = Language::all();
			foreach($lang as $l) {
				$school = CategoryLang::where(['category_id' => $id, 'lang' => $l->code])->first();
				$school->name = $request->name[$l->code];
				$school->save();
			}
			
			return response()->json(['return' => true,'message' => 'Kategori başarı ile duzenlendi.'],200);
		}catch (\Exception $e) {
			return response()->json(['message' => $e->getMessage()],500);
		}
    }
    
    public function getCategoryDelete($id) {
		if($id != '' && $id != 0) {
			Category::where('id',$id)->delete();
			return response()->json(['return' => true,'message' => 'Kategori başarı ile silindi.'],200);
		}
	}
	
	public function getCategoryLangDelete($id) {
		if($id != '' && $id != 0) {
			CategoryLang::where('category_id',$id)->delete();
			return response()->json(['return' => true,'message' => 'Kategori başarı ile silindi.'],200);
		}
	}
}