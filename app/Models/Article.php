<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {
    protected $fillable = ["article_id", "user_id", "title", "news_info", "min_age"];
    
}