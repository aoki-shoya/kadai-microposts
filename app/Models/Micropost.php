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
}
