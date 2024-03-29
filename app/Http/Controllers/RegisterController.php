<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        //set validation
        $validator = Validator::make($input, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $user = User::create([
            'name'      => $input['name'],
            'email'     => $input['email'],
            'password'  => bcrypt($input['password']),
            'role_id' => '2'
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 200);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function getUser($id){
        $use = User::find($id);
        return response()->json($use);
    }
    public function updateUser($id,  Request $request){
        $usr = User::where('id',$id)->first();
        $usr->name = $request->name;
        $usr->email = $request->email;
        $usr->save();
        //return response JSON user is created
        return response()->json([
            'success' => true,
            'user'    => $usr,
            'status' => 200,
            'message' => 'Successfully Edit Data' 
        ], 200);
    }

}