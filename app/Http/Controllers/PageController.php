<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
   
     /**
      * Check validation for page request data
      * This method create a new page for logged in persons
      * Route: api/page/create
     */

    public function store(Request $request){
        $validateData = $request->validate([
            'page_name' => "required|string",
        ]);

        $data = new Page();

        $data->page_name = $request->page_name;
        $data->user_id = Auth::id();

        $data->save();

        return response()->json([
            'success' => true,
            'message' => "Page created successfully"
        ]);
    }

    public function AddPageFollower($page_id){

        $data = new PageUser();

        $data->user_id = Auth::id();
        $data->page_id = $page_id;

        $data->save();

        return response()->json([
            'success' => true,
            'message' => "You are following this page"
        ]);
    }
}
