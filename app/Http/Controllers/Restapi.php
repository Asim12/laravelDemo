<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Restapi extends Controller
{

    public function __construct()
    {
        // if (!Auth::check()) return 'NO';
        ini_set("display_errors", E_ALL);
        error_reporting(E_ALL);
    }
    

    public function index(Request $request){
        echo "testing";
        return response()->json('testing', 200);
    }


    public function getPost(Request $request){

        // $username = md5($request->header('PHP_AUTH_USER'));
        // $password = md5($request->header('PHP_AUTH_PW'));
        $username = $request->header('PHP_AUTH_USER');
        $password = $request->header('PHP_AUTH_PW');
        $received_Token = $request->header('Authorization');

        $response = [
            'success' => true,
            'username'  => $username,
            'password' => $password,
            'received_Token' => $received_Token
        ];

    
        return response()->json($response, 200);
    }


    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         'c_password' => 'required|same:password',
    //     ]);
   
    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());       
    //     }
   
    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $user = User::create($input);
    //     $success['token'] =  $user->createToken('MyApp')->accessToken;
    //     $success['name'] =  $user->name;
   
    //     return $this->sendResponse($success, 'User register successfully.');
    // }
    //
}
