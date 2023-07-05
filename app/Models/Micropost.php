<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    use HasFactory;
    protected $fillable = ['content'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //この投稿をお気に入りにしたユーザ
    public function favorite_user()
    {
        return $this->belongsToMany(Micropost::class,'favorites','micropost_id','user_id')->withTimestamps();
    }
    
    //この投稿(1)に対する返信(多)　１対多の関係
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
    
    //この投稿が持つ返信の数(threads)をカウントする
    public function loadRelationshipCounts()
    {
        $this->loadCount('threads');
    }
//        public function threads_count()
//    {
//        return $this->hasMany(Thread::class)->count();
//    }
}
