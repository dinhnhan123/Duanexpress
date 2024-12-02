<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'desc',
        'slug',
        'content',
        'status',
        'user_id'
    ];

     function user(){
        return $this->belongsTo('App\Models\User');
     }
}
