<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'content',
    ];
    
    //この返信を所有する投稿(micropost)
    public function micropost()
    {
        return $this->belongsTo(Micropost::class);
    }
    
    //この返信を所有するユーザ
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
