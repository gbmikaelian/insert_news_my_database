<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use app\Article;
class Image extends Model
{
    protected $tabele = 'images';
    protected $fillable = ['image_name'];
    public function article()
    {
        return $this->belongsTo('App\Article', 'id', 'article_id');
    }
}
