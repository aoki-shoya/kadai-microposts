<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facede\Auth;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(10);
        
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        $user->loadRelationshipCounts();
        
        $microposts = $user->microposts()->orderBy('created_at','desc')->paginate(10);
        
        
        return view('users.show', [
           'user' => $user, 
           'microposts' => $microposts,
        ]);
    }
    
    public function followings($id)
    {
        $user = User::findOrFail($id); //$idの値でユーザを検索して取得
        
        $user->loadRelationshipCounts(); //関係するモデルの件数を取得
        
        $followings = $user->followings()->paginate(10); //ユーザのフォロー一覧を取得
        
        return view('users.followings', [ //フォロー一覧ビューでそれらを取得
            'user' => $user,
            'users' => $followings,
        ]);
    }
    
    public function followers($id)
    {
        $user = User::findOrFail($id);
        
        $user->loadRelationshipCounts();
        
        $followers = $user->followers()->paginate(10);
        
        return view('users.followers', [ //フォロワー一覧ビューでそれらを取得
           'user' => $user,
           'users' => $followers,
        ]);
    }
    
    public function favorites($id)
    {
        $user = User::findOrFail($id);
        
        $user->loadRelationshipCounts();
        
        $favorites = $user->favorites()->paginate(10);
        
        return view('users.favorites', [
           'user' => $user,
           'microposts' => $favorites,
        ]);
    }
}
