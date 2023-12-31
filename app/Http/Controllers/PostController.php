<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function createpost(Request $Request){
        $incomingdata = $Request->validate([
            'title'=>'required',
            'body' =>'required'
        ]);

        $incomingdata['title'] = strip_tags($incomingdata['title']);
        $incomingdata['body'] = strip_tags($incomingdata['body']);
        $incomingdata['user_id'] = auth()->id();
        Post::create($incomingdata);
        return redirect('/');
    }

    function editpost(Post $post){
        if(auth()->user()->id !== $post['user_id']){
            return redirect('/');
        }
        return view('editpost', ['post' => $post]);
        
    }

    function updatepost(Post $post, Request $request){
        if(auth()->user()->id !== $post['user_id']){
            return redirect('/');
        }
        $incomingdata = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $incomingdata['title'] = strip_tags($incomingdata['title']);
        $incomingdata['body'] = strip_tags($incomingdata['body']);
        $post->update($incomingdata);
        return redirect('/');
    }

    function deletepost(Post $post){
        if(auth()->user()->id === $post['user_id']){
            $post->delete();
        }

        return redirect('/');
    }
    
}
