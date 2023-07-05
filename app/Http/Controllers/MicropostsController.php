<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Micropost;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if(\Auth::check()) { //認証済みか確認
            $user = \Auth::user(); //認証済みユーザを取得
            //ユーザとフォロー中ユーザの投稿の一覧を作成日時の降順で取得(Userモデルで定義した関数を使う)
            $microposts = $user->feed_microposts()->orderBy('created_at','desc')->paginate(5);
            $user->loadRelationshipCounts();
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
        
        return view('dashboard',$data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
           'content' => 'required|max:255', 
        ]);
        
        $request->user()->microposts()->create([
           'content' => $request->content, 
        ]);
        
        return back();
    }
    
    public function destroy($id)
    {
        $micropost = \App\Models\Micropost::findOrFail($id);
        
        if(\Auth::id() === $micropost->user_id) {
            $micropost->delete();
            return back()->with('success','Delete Successful');
        }
        
        return back()->with('Delete Failed');
    }
    
    public function edit($id)
    {
        $micropost = \App\Models\Micropost::findOrFail($id);
        
        if(\Auth::id() === $micropost->user_id) {
            return view('microposts.edit', [
                'micropost' => $micropost,    
            ]);
        }
        else {
            return back();
        }
    }
    
    public function update(Request $request,$id)
    {
        $micropost = Micropost::findOrFail($id); //編集ボタンから受け取った$idで検索
        
        if(\Auth::id() === $micropost->user_id) { //ログインしているidと検索して取得したレコードのuser_idが一致したら
            
            $request->validate([ //受け取った値のバリデーション
                'content' => 'required',
            ]);
            
            $micropost->content = $request->content;
            $micropost->save();
            
            $user = \Auth::user(); //ログインしているユーザ情報を取得
            $microposts = $user->feed_microposts()->orderBy('created_at','desc')->paginate(10);
            
            return redirect()->route('dashboard');
        }
        return view('dashboard');
    }
}
