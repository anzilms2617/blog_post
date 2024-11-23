<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
{
    
    $posts = Post::all();
    $authors = Post::distinct()->pluck('author');

    return view('posts.index', compact('posts', 'authors'));
}

    
    public function create()
    {
        return view('posts.create');
    }

   
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'author' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

       
        $post = new Post();
        $post->name = $request->name;
        $post->date = $request->date;
        $post->author = $request->author;
        $post->content = $request->content;  

        
        if ($request->hasFile('image')) {
            
            $originalFileName = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('post_image'); 
            $request->file('image')->move($destinationPath, $originalFileName);
            $post->image = 'post_image/' . $originalFileName;
        }

        $post->save();
        return response()->json(['message' => 'Post created successfully!'], 200);
    }


    public function edit($id)
{
    $post = Post::findOrFail($id);
    return view('posts.edit', compact('post'));
}

public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'author' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        $post = Post::findOrFail($id);
        $post->name = $request->name;
        $post->date = $request->date;
        $post->author = $request->author;
        $post->content = $request->content; 

        
        if ($request->hasFile('image')) {
            
            $originalFileName = $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('post_image');
            $request->file('image')->move($destinationPath, $originalFileName);
            $post->image = 'post_image/' . $originalFileName;
        }

        $post->save();
        return response()->json(['message' => 'Post updated successfully!'], 200);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Post deleted successfully.',
                'postId' => $id,
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
   
}
