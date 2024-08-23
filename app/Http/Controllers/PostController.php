<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use DB;

class PostController extends Controller
{
    
    public function update(Request $request){
        // walidacja
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:posts,id',
            'name' => 'required|alpha|max:255',
            'surname' => 'required|alpha|max:255',
            'email' => 'required|email|max:255'
        ]);

        // pobranie rekordu z bazy
        $post = Post::find($validatedData['id']);

        // aktualizacja danych
        $post->name = $validatedData['name'];
        $post->surname = $validatedData['surname'];
        $post->email = $validatedData['email'];

        $post->save();

        return response()->json(['message' => 'Post updated successfully!']);
    }

    public function delete(Request $request){
        // walidacja
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:posts,id'
        ]);

        // pobranie rekordu z bazy
        $post = Post::find($validatedData['id']);

        $post->delete();

    }
    
    public function show()
    {
        return response()->json(['message' => 'Wszystko dziala!']);
    }


}
