<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;

class ArticleController extends Controller{

    //updating an article
    function updateArticle($article_id, Request $request){
        $user = User::where("user_id", $request->user_id)->first();
        if($user && $user->user_type == 'admin'){
            $article = Article::find($article_id);

            $article->title = $request->title;
            $article->info = $request->info;
            $article->min_age = $request->min_age;
            $article->save();

            return response()->json([
                "updated_article"=>$article
            ]);
        }
        return response()->json([
            "error" => "unauthorized"
        ]);
        
    }

    //creating an article
    function createArticle(Request $request){
        $article = new Article;
        $article->user_id = $request->user_id;
        $article->title = $request->title;
        $article->info = $request->info;
        $article->min_age = $request->min_age;

        $article->save();

        return response()->json([
            "new_article"=>$article
        ]);
    }

    //reding articles
    function getArticle($article_id, Request $request){
        $user = User::where("user_id", $request->user_id)->first();
        if(!$user){
            return response()->json([
                "error"=>"unauthorized"
            ]);
        }
        $article = Article::find($article_id);
        if($article){
            return response()->json([
                "article" => $article
            ]);
        }
        return response()->json([
            "error" => "Article not found"
        ]);
    }

    // function getArticles(){
    //     $articles = Article::all();

    //     return response()->json([
    //         "articles" => $articles
    //     ]);
    // }

    //removing article
    function removeArticle($article_id, Request $request){
        $user = User::where("user_id", $request->user_id)->first();
        if($user && $user->user_type =='admin'){
            $article = Article::find($article_id);
            if ($article){
                $article->delete();

                return response()->json([
                    "deleted_article" => true
                ]);
            }
            return response()->json([
                "error" => "article not found"
            ]);  
        }
        return response()->json([
            "error" => "unauthorized"
        ]);   
    }
}