<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Validator;
use Response;
use Illuminate\Support\Facades\input;
use App\Http\Requests;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::paginate(4);
        return view('post.index', compact('post'));
    }

    public function addPost(Request $req)
    {
        $rules = array(
            'title' => 'required',
            'body' => 'required',
        );

        $validator = Validator::make (input::all(), $rules);
        if ($validator->fails())
        {
            return response::json(array('errors'=> $validator->getMessageBag()->toarray()));
        }
        else
        {
            $post = new Post;
            $post->title = $req->title;
            $post->body = $req->body;
            $post->save();
            return response()->json($post);
        }


    }

    public function editPost(Request $req)
    {
        $post = Post::findOrFail($req->id);
        $post->title = $req->title;
        $post->body = $req->body;
        $post->save();
        return response()->json($post);
    }

    public function deletePost(Request $req)
    {
        $post = Post::findOrFail($req->id);
        $post->delete();
        return response()->json();
    }
}
