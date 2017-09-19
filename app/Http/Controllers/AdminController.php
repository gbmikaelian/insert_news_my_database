<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $sincronization = new Article;
        $inserted = $sincronization->sincronization();

        $articles = Article::orderBy('id', 'desc')->limit(332)->get();
        foreach ($articles as $item) {
            $id = $item->id;
        }
        $articles = new Article();
        $deleted = $articles->delete_posts($id);


        $articles = Article::orderBy('id', 'desc')
            ->limit(1000)
            ->get();
        return view('admin', [
            'articles' => $articles,
            'inserted' => $inserted,
            'deleted' => $deleted
        ]);

    }
}
