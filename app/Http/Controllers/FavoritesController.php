<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    //投稿をお気に入りするアクション
    public function store($id)
    {
        \Auth::user()->add_favorite($id);
        
        //前のURLにリダイレクト
        return back();
    }
    
    //投稿のお気に入りを外すアクション
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        
        return back();
    }
}
