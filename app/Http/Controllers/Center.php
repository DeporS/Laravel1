<?php

namespace App\Http\Controllers;
use Illuminate\View\View;

use Illuminate\Http\Request;
use DB;
use App\Models\Post;
use Carbon\Carbon;

class Center extends Controller
{
    public function show(): View
    {
        $posts = new Post;
        $posts = DB::table('posts')->select("*")->get();

        foreach ($posts as $post){
            if ($post->created_at){
                $post->created_at = Carbon::parse($post->created_at)->format('H:i - d.m.Y');
            }
            if ($post->updated_at){
                $post->updated_at = Carbon::parse($post->updated_at)->format('H:i - d.m.Y');
            }
        }


        return view("formCenter", compact('posts'));
    }
}
