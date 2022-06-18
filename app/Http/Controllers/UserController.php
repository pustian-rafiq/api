<?php

namespace App\Http\Controllers;

use App\Models\FollowUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function GetUser(){
        return User::all();
    }


    public function AddUserFollower($following_id){

    $data = new FollowUser();

    $data->user_id = Auth::id();
    $data->following_id = $following_id;

    $data->save();

    return response()->json([
        'success' => true,
        'message' => "You are following this person"
    ]);
}
}
