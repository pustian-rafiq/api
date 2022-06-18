<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
 

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']] );
    }
 
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            // "firstName" => "required|string",
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:6",
        ]);

        if($validator->fails()){
            return response()->json([
                "errors" => $validator->errors(),
            ],400);
        }
        $person = new User();

        // $person->firstName = $request->firstName;
        $person->name = $request->name;
        $person->email = $request->email;
        $person->password = bcrypt($request->password);

        $person->save();

        return response()->json([
            "message" => "Person inserted successfully",
            "data" => $person
        ],201);
    }

    // public function Login(Request $request){
    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);
       // $credentials = $request->only('email', 'password');
        // try {
        //     if (!$token = JWTAuth::attempt($credentials)) {
        //         return response()->json(['error' => 'Invalid Credentials'], 401);
        //     }
        // }catch (JWTException $e) {
        //     return response()->json(['error' => 'Could not create token'],500);
        // }
        //return response()->json(['token' => $token], 200);
   // }


   public function login(Request $request)
   {
    $credentials = $request->only('email', 'password');

    if ($token = $this->guard()->attempt($credentials)) {
        return $this->respondWithToken($credentials,$token);
    }

    return response()->json([
        'error' => 'Unauthorized'], 401);
   }


   protected function respondWithToken($credentials,$token)
   {
       return response()->json([
            'data' => $credentials,
           'access_token' => $token,
           'token_type' => 'bearer',
           'expires_in' => $this->guard()->factory()->getTTL() * 60
       ]);
   }

   public function guard()
   {
       return Auth::guard();
   }
   
   public function profile(){
    return response()->json(Auth::user());
   }
  

}
