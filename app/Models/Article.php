<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // app/Models/Article.php

protected $fillable = ['title', 'url', 'posted_date', 'article_contents'];
// app/Models/Article.php

protected $casts = [
    'posted_date' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];



}
