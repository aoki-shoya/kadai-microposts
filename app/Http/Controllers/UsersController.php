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
    
    public function profile($id)
    {
        $user = User::find($id);
        
        $user->loadRelationshipCounts();
        $message = "";
        
        return view('users.profile', [
            'user' => $user,   
            'message' => $message,
        ]);
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        
        if(\Auth::id() === $user->id) {
            return view('users.edit', [
                'user' => $user, 
            ]);
        }
        else {
            return back();
        }
    }
    
    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->loadRelationshipCounts();
        
        
        if(\Auth::id() === $user->id) { //ログインしているIDと受け取ったIDが同じだったら
        
            $request->validate([ //受け取った値のバリデーション
                'name'=>'required',
                'age'=>'required',
                'gender' => 'required'
            ]);
            
            $user->name = $request->name;
            $user->age = $request->age;
            $user->gender = $request->gender;
            $user->save();
            
            $message = 'プロフィールを更新しました';
            
            return view('users.profile',[
                'user' => $user,
                'message' => $message,
            ]);
        }
        
        return redirect('/');
    }
}
