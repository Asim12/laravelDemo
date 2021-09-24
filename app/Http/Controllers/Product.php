<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
// $users = User::all();

class Product extends Controller
{

    public function __construct(){
        $this->users = new users();
    }


    public function index(){

        $data = $this->users->testingData();
        echo "asim testing";
        echo "<pre>";
        print_r($data);
    }

    public function newFunction(){
        echo "2nd function";
    }
}



//create session
// Session::put('key', 'value');
    //OR
// session(['key' => 'value']);


//get session data
// $value = Session::get('key');
        //OR
// $value = session('key');

// $data = Session::all();


// if (Session::has('users'))
// {
//     //
// }

// Session::forget('key');
