<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCatHome extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'post_title',
        'category_name',
        'category_slug',
        'category_status',
        'category_content',
        'image_id',
        'parent_id',
        'user_id'
    ];
    function user(){
        return $this->belongsTo('App\Models\User');
    }
    function image(){
        return $this->belongsTo('App\Models\Image');
      }
}
