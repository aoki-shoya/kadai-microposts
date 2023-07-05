<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'gender',
        'age',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // このユーザが所持する投稿
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    // このユーザが所有する返信
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
    
    public function loadRelationshipCounts()
    {
        $this->loadCount('microposts','followings','followers','favorites');
    }
    
    //このユーザがフォロー中のユーザ
    public function followings()
    {
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
    }
    
    //このユーザをフォロー中のユーザ
    public function followers()
    {
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }
    
    //$userIdで指定されたユーザをフォローする
    public function follow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if($exist || $its_me) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    //$userIdで指定されたユーザのフォローを外す
    public function unfollow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me) {
            $this->followings()->detach($userId);
            return true;
        } else {
            return false;
        }
    }
    
    //指定された$useIdのユーザをこのユーザがフォロー中か調べてフォロー中ならtrue
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id',$userId)->exists();
    }
    
    //このユーザがお気に入りした投稿
    public function favorites()
    {
        return $this->belongsToMany(Micropost::class,'favorites','user_id','micropost_id')->withTimestamps();
    }
    
    //$micropostIdで指定された投稿をお気に入りにする
    public function add_favorite($micropostId)
    {
        $exist = $this->is_favoritings($micropostId);
        //$its_me = $this->id == $micropostId; 必要ない
        
        if($exist) { //お気に入りにしていたらfalse
            return false;
        } else { //お気に入りしていなかったらお気に入り登録する処理の実行
            $this->favorites()->attach($micropostId);
            return true;
        }
    }
    
    //$micropostIdで指定された投稿のお気に入りを外す
    public function unfavorite($micropostId)
    {
        $exist = $this->is_favoritings($micropostId);
        //$its_me = $this->id == $micropostId->user_id;
        
        if($exist) { //お気に入りされていたらお気に入りを外す処理
            $this->favorites()->detach($micropostId);
            return true;
        } else { 
            return false;
        }
    }
    
    //指定された$micropostIdの投稿をこのユーザがお気に入りしているか調べてお気に入り済みならtrue
    public function is_favoritings($micropostId)
    {
        return $this->favorites()->where('micropost_id',$micropostId)->exists();
    }
    
    //このユーザとフォロー中のユーザの投稿に絞り込む
    public function feed_microposts()
    {
        //このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        //このユーザのidもその配列に追加
        $userIds[] = $this->id;
        //それらのユーザが所有する投稿に絞り込む
        return Micropost::whereIn('user_id',$userIds);
    }
}
