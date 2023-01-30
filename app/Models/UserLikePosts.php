<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikePosts extends Model
{
    use HasFactory;

    protected $table = 'user_like_posts';

    protected $fillable = ['user_id', 'post_id'];
}
