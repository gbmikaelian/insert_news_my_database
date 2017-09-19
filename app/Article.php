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
    public function sincronization(){
        $xml = simplexml_load_file('http://www.tert.am/am/news/rss', 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($xml);
        $arr = json_decode($json, 1);
        $count = 0;
        $date = date('m-d-Y');
        foreach ($arr['channel']['item'] as $item) {

            if (!file_exists('images/uploads/' . $date)) {
                $mkdir = mkdir('images/uploads/' . $date);
            } else {
                $mkdir = 'images/uploads/' . $date;
            }
            $article = new Article();
            $images = new Image();
            $file_path = $item['enclosure']['@attributes']['url'];
            $link = $item['link'];
            $md5 = md5($link);
            $articles = Article::where('link', $link)->first();
            if (!$articles) {
                $article->title = $item['title'];
                $article->description = $item['description'];
                $article->link = $item['link'];
                $article->image_path = $file_path;
                $article->pubDate = $item['pubDate'];
                $article->save();
                $path = $file_path;
                $filename = basename($path);
                $file = file_get_contents($path);
                file_put_contents($mkdir . '/' . $md5 . $filename, $file);
                $images->image_name = $date . '/' . $md5 . $filename;
                $images->article_id = $article->id;
                $images->save();
                $count++;


            }
        }
       return  $count ? 'Ավելացել է ' . $count . ' տվյալ' : 'Նոր տվյալներ չեն ավելացել';
    }
    public function delete_posts($id){
        $articles  = Article::all()->where('id', '<', $id);
        $count = 0;
        foreach ($articles as $article) {
            if ($article->delete()) {
                $file = 'images/uploads/'.$article->image->image_name;
                if (file_exists($file)){
                    unlink($file);
                    $article->image->delete();
                    $count++;
                }
            }
        }
        return $count ? 'Ջնջվել է ' . $count . ' տվյալ' : 'Ոչինչ չի ջնջվել';
    }


}
