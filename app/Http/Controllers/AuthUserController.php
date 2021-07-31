<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthUserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('email', $request->input('email')) -> first();
        $response = (object)[];

        if($user) {
            $response->status = 200;
            $response->body = $user;
            return $response;
        } else { 
            $response->message = "User not registered";
            $response->code = 400;
            return json_encode($response);
        }
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
    
    }

    public function show($id)
    {
      
    }

    public function update(Request $request, $id)
    {
    
    }

    public function destroy($id)
    {
        
    }
}
