<?php
namespace App\Http\Controllers\API;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repository\IUserRepository;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public $successStatus = 200;
    public $iUserRepository;

    public function __construct(IUserRepository $iUserRepository)
	{
		$this->iUserRepository = $iUserRepository;
	}

    /**
     * obtem uma lista de usuários
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->iUserRepository->findAll();
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
        DB::beginTransaction();
        try {
            $validator = $this->iUserRepository->validate($request->all());
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 
            $user = User::create($input); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name']  =  $user->name;
            DB::commit();
            return response()->json(['success'=> $success], $this->successStatus);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error'=> $e->message], $this->successStatus); 
        }
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