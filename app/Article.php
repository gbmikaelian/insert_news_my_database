<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Image;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable= [
        'title',
        'description',
        'link'
    ];

    public function image()
    {
        return $this->hasOne('App\Image', 'article_id', 'id');
    }
    public function delete_articles($id)
    {

    }

}
