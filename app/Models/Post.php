<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate(int $int)
 * @method static create(array $validate)
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = ["title", "body", "topic"];
    /**
     * @var mixed
     */


    function author(){
      return  $this->belongsTo(User::class, 'user_id');
    }

    function topics(){
        return $this->belongsToMany(Topic::class, 'post_topic', 'post_id', 'topic_id');
    }

}
