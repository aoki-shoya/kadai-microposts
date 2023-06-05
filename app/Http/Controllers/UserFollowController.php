<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    public function store($id) 
    {
        \Auth::user()->follow($id); //認証済みユーザが$idのユーザをフォローする
        return back();
    }
    
    public function destroy($id)
    {
        \Auth::user()->unfollow($id); //認証済みユーザが$idのユーザのフォローを外す
        return back();
    }
}
