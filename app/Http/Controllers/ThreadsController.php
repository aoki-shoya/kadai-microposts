<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Micropost;
use App\Models\Thread;

class ThreadsController extends Controller
{
    public function index($id)
    {
        $micropost = Micropost::find($id);
        $user = User::find($micropost->user_id);
        $threads = $micropost->threads()->orderBy('created_at','desc')->paginate(5);
        $message = "haha";
        return view('threads.threads', [
            'micropost' => $micropost,
            'threads' => $threads,
            'user' => $user,
            'message' => $message,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
           'content' => 'required|max:255', 
        ]);

        $micropost = Micropost::find($request->id);
        $micropost->threads()->create([
           'user_id' => \Auth::id(),
           'content' => $request->content,
        ]);
        return back();
    }
    
    public function edit($id) {
        $thread = Thread::findOrFail($id);
        
        if(\Auth::id() === $thread->user_id) {
            return view('threads.edit', [
               'thread' => $thread,
            ]);
        } else {
            return back();
        }
    }
    
    public function update(Request $request,$id)
    {
        $thread = Thread::findOrFail($id); //編集ボタンから受け取った$idで検索
        
        if(\Auth::id() === $thread->user_id) { //ログインしているidと検索して取得したレコードのuser_idが一致したら
            
            $request->validate([ //受け取った値のバリデーション
                'content' => 'required',
            ]);
            
            $thread->content = $request->content; //フォームから受け取った内容を
            $thread->save();
            
            $message = '編集しました';
            return redirect()->route('threads',$thread->micropost_id);
        }
        return view('dashboard');
    }
    
    public function destroy($id)
    {
        $thread = Thread::findOrFail($id);
        if(\Auth::id() === $thread->user_id) {
            $thread->delete();
            return back()->with('success','Delete Successful');
        } else {
            return back()->with('Delete Failed');   
        }
    }
}
