<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;


    protected $fillable = ["tag"];


    function posts(){
        return $this-> belongsToMany(Post::class, 'post_topic', 'topic_id', 'post_id');
    }
}
