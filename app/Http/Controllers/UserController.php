<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller{

    function createUser(Request $request){
        $user = new User;
        $user->user_type = $request->user_type;
        $user->user_age = $request->user_age;
        $user->save();

        return response()->json([
            "new_user" => $user
        ]);
    }
    function getArticle($article_id, Request $request){
        $user = User::where("user_id", $request->user_id)->first();
        if(!$user){
            return response()->json([
                "error"=>"unauthorized"
            ]);
        }
        $article = Article::where("article_id", $article_id)
                            ->where("min_age" <= $user->user_age)
                            ->first();
        if($article){
            return response()->json([
                "article" => $article
            ]);
        }
        return response()->json([
            "error" => "Article not found"
        ]);
    }
}