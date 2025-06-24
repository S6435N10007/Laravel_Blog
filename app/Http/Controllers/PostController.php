<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(1);
        return view('index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required'
        ]);
        Post::create($request->only(['title','content']));
        return redirect()->route('index')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('show',compact('post'));
    }

    /**
     * Search the specified resource.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        if ($query){
            $posts = Post::where('title', 'like', '%' . $query . '%')
                            ->orWhere('content', 'like', '%' . $query . '%')
                            ->paginate(1);
        }                   
        else{
            $posts = Post::paginate(1);
        }
        return view('index', compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required'
        ]);
        $post->update($request->only('title','content'));
        return redirect()->route('index')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('index')->with('success','Post Deleted');
    }
}
