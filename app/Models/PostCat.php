<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCat extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_name',
        'category_slug',
        'category_status',
        'parent_id',
        'user_id'
    ];
    function user(){
        return $this->belongsTo('App\Models\User');
    }
    function posts(){
        //bên bảng post khóa ngoại tên gì thì mình dùng tên đấy mới lấy được
        return $this->hasMany('App\Models\Post','category_id');
    }
}
