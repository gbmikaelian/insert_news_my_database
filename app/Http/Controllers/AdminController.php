<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $sincronization = new Article;
        $response = $sincronization->sincronization();
        $articles = Article::orderBy('id', 'desc')
            ->limit(1000)
            ->get();
        return view('admin', [
            'articles' => $articles,
            'response' => $response
            ]);




    }
}
