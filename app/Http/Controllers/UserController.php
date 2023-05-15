<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    function register(Request $req){
        $user=new User;
        $user->login=$req->input('login');
        $user->email=$req->input('email');
        $user->tel=$req->input('tel');
        $user->join_time=$req->input('join_time');
        $user->role=$req->input('role');
        $user->password= Hash::make($req->input('password'));
        $user->save();
        return $user;
    }
    
    function login(Request $req){
        $user = User::where('email', $req->email)->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
        return $user;
    }

    function getUser($id){
        
        {
            $user = User::find($id);
            return response()->json($user);
        }
    }

    public function update(Request $request, $id)
{
    $user = User::find($id);
if (empty($request->oldPassword)){
        $user->login = $request->login;
        $user->email = $request->email;
        $user->tel = $request->tel;
        $user->join_time=$request->join_time;
        $user->role=$request->role;        
        // $user->update(['password'=> Hash::make($request->password)]);
        $user->password= Hash::make($request->input('password'));   
        $user->save();  
    }
else{
    if (!Hash::check($request->oldPassword, $user->password)) {
        return response()->json(['error' => 'Invalid password'], 401);
    }
    else{
    $user->login = $request->login;
    $user->email = $request->email;
    $user->tel = $request->tel;
    $user->join_time=$request->join_time;
    $user->role=$request->role;        
    // $user->update(['password'=> Hash::make($request->password)]);
    $user->password= Hash::make($request->newPassword);   
    $user->save();}
}    
    return $user;
}   
 


}