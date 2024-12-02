<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'post_title',
        'post_slug',
        'content',
        'post_status',
        'category_id',
        'image_id',
        'user_id',
        'category_id_before',
        'post_description'
    ];
    function image(){
      return $this->belongsTo('App\Models\Image');
    }
    function category(){
      return $this->belongsTo('App\Models\PostCat');
    }
    function user(){
      return $this->belongsTo('App\Models\User');
    }
}
