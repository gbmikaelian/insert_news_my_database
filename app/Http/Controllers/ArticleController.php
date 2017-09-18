<?php

namespace App\Http\Controllers;


use App\Article;
use App\Image;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $response = $count ? 'Ավելացել է ' . $count . ' տվյալ' : 'Նոր տվյալներ չեն ավելացել';
        return redirect('admin')->with('status', $response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $article =  Article::find($id);
        $article->title = $request->title;
        $article->description = $request->description;
        $article->link = $request->link;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $date = date('m-d-Y');
            $file->move('images/uploads/'.$date, $file
            ->getClientOriginalName());

            $article->image->image_name = $date.'/'.$file
            ->getClientOriginalName();
            if (file_exists('images/uploads/'.$request->old_image_path)){
                unlink('images/uploads/'.$request->old_image_path);
            }
        }
        if ($article->push()) {
            return redirect('admin')->with('status', 'Փոփոխությունը հաջողությամբ կատարվել է');

        }
            return redirect('admin')->with('status', 0);


    }
    public function destroy($id)
    {
        $article = Article::find($id);

        if ($article->delete()) {

            $file = 'images/uploads/'.$article->image->image_name;
            if (file_exists($file)){
                unlink($file);
                $article->image->delete();
            }
            return redirect('admin')->with('status', 'Ջնջվեց '.$article->id.' նորությունը');
        }
        return redirect('admin')->with('status', 0);

    }
}
