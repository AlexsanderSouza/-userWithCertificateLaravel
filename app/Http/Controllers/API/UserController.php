<?php
namespace App\Http\Controllers\API;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * obtem uma lista de uuários
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); 
        return response()->json(['users' => $users], $this->successStatus); 
    }

    /**
     * Cria um novo usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = User::validate($request->all());
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus); 
    }

    /**
     * obtem um usuário
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(['user'=>$user], $this->successStatus); 
    }
}