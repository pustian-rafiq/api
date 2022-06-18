<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
     /**
      * Check validation for post request data
      * This method create a new post for logged in persons
      * Route: api/person/attach-post
     */
    public function UserPostStore(Request $request){
        $validateData = $request->validate([
            'post_content' => "required|string",
        ]);

       

         $data = new Post();

        $data->post_content = $request->post_content;
        $data->user_id = Auth::id();
 
        $data->save();

        return response()->json([
            'success' => true,
            'message' => "Post created successfully"
        ]);
       
    }


    public function PagePostStore(Request $request,$page_id){
        $validateData = $request->validate([
            'post_content' => "required|string",
        ]);

        $page = Page::where('user_id',AUth::id())->find($page_id);

        $data = new Post();

       
        if($page){
            $data->post_content = $request->post_content;
            $data->user_id = Auth::id();
            $data->page_id = $page_id;

            $data->save();

            return response()->json([
                'success' => true,
                'message' => "Post created successfully"
            ]);
        } else{
            return response()->json([
                'success' => false,
                'message' => "This page not exist"
            ]); 
        }
    }

    //Fetch all post for person
    public function GetAllPost(){
        $data = Post::where('user_id', Auth::id())
        ->where('page_id',null)
        ->select('post_content','user_id')
        ->get();

        return view('welcome',compact('data'));
    }
}
