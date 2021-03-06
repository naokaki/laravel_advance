<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users";
    protected $dates = ["deleted_at"];
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function movies(){
        return $this->hasmany(Movie::class);
    }
    
    public function followings(){
        return $this->belongsToMany(User::class, "user_follow", "user_id", "follow_id")->withTimestamps();
        
    }
    
    public function followers(){
        return $this->belongsToMany(User::class, "user_follow", "follow_id", "user_id")->withTimestamps();
        
    }
    
    public function is_following($userId){
        return $this->followings()->where("follow_id", "$userId")->exists();
        
    }
    
    public function follow($userId){
        //すでにフォロー済みではないか？
        $existing = $this->is_following($userId);
        //フォローする相手がユーザー自身ではないか？
        $myself = $this->id == $userId;
        
        //フォロー済みではない、かつフォロー相手がユーザ自身ではない場合、ふぉろー
        if(!$existing & !$myself){
            $this->followings()->attach($userId);
        }
    }
    
    public function unfollow($userId){
        //すでにフォロー済みではないか？
        $existing = $this->is_following($userId);
        //フォローする相手がユーザ自身ではないか？
        $myself = $this->id == $userId;
        
        //すでにフォロー済みならば。フォローを外す
        if($existing && !$myself){
            $this->followings()->detach($userId);
        }
    }
    
}
