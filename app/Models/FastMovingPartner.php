<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FastMovingPartner extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'url',
        'description',
        'order',
        'image_id',
        'user_id',
        'status'
    ];
    function image(){
        return $this->belongsTo(Image::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
}
