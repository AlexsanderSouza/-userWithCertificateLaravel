<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public $successStatus = 200;
    
    /** 
     * faz login na api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){
        /* verifica se o usuário existe */
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['user']  =  $user;
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json($success, $this->successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthenticated'], 401); 
        } 
    }

    /**
     * remove o token do usuário
     *
     * @authenticated
     * @response status=204 scenario="Success" {}
     * @response status=400 scenario="Unauthenticated" {
     *     "message": "Unauthenticated."
     * }
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([], 204);
    }
}