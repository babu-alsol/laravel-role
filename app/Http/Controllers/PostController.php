<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category')->get();

        if ($posts->count() > 0){
            return response()->json([
                'status' => 'Ok',
                'data' => $posts
            ]);
        }else{
            return response()->json([
                'status' => 'No Posts to show',
                //'data' => $students
            ]);
        }
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'category_id' => 'required'
        ]);

        $data = $request->all();
        //$data['user_id'] = auth()->user()->id;

        Post::create($data);

        return response()->json([
            'status' => 'okay',
            'message' => 'Post Created Succesffuly',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if ($post){
            return response()->json([
                'status' => 'Ok',
                'data' => $post
            ]);
        }else{
            return response()->json([
                'status' => 'No Post to show',
                //'data' => $students
            ]);
        }
    }

  
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required',
            'category_id' => 'required'
        ]);

        $data = $request->all();
       // $data['user_id'] = auth()->user()->id;
        $post->fill($data);
        $post->save();

        Post::create($data);

        return response()->json([
            'status' => 'okay',
            'message' => 'Post Created Succesffuly',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post){
            $post->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Post deleted Succesffuly',
                'data' => $post
            ]);
        }else{
            return response()->json([
                'status' => 501,
                'message' => 'Post does not exist',
              
            ]);
        }
    }
}
