<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Store;

class StoreController extends Controller
{
    public function show($id)
    {
        // 引数で受け取ったIDni対応するストアを取得
        $store = Store::findOrFail($id);

        // 取得したストアを詳細ページに渡して表示する
        return view('store_detail',['store' => $store]);
    }

public function index()
{
    $userFavoriteStores = auth()->check() ? auth()->user()->favorites->pluck('store_id')->toArray() : [];

    $stores = Store::with(['area', 'genre'])->get();
    
    return view('index', compact('stores', 'userFavoriteStores'));
}

    public function search(Request $request)
{
    $areaId = $request->input('area_id');
    $genreId = $request->input('genre_id');

    $query = Store::query();

    if ($areaId) {
        $query->where('area_id', $areaId);
    }

    if ($genreId) {
        $query->where('genre_id', $genreId);
    }

    $stores = $query->get();
    
    return view('index', compact('stores'));
}


    public function store(Request $request)
    {
        // ストアを追加するロジックをここに記述
    }

    public function destroy(Store $store)
    {
        // ストアを削除するロジックをここに追加
    }

     public function storesByArea(Area $area)
    {
        $stores = $area->stores;
        return view('stores.index', compact('stores'));
    }
}