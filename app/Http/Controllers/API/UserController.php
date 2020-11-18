<?php
namespace App\Http\Controllers\API;
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
     * retorna o usuário logado
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json($user, $this->successStatus); 
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
            /* verifica se o usuário é valido */
            $validator = $this->iUserRepository->validate($request->all());
            if ($validator->fails()) return response()->json(['error'=> $validator->errors()], 401);

            /* todos os dados do corpo da requisição */
            $input = $request->all(); 
            /* encripta a senha */
            $input['password'] = bcrypt($input['password']); 
            /* cria o usuário */
            $user = $this->iUserRepository->create($input);
            /* cria um token */
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['user']  =  $user;

            DB::commit();
            return response()->json($success, $this->successStatus);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error'=> $e->message], $this->successStatus); 
        }
    }

    /**
     * Atualiza um usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $userId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId)
    {
        DB::beginTransaction();
        try {
            /* verifica se o usuário e o id é valido */
            $validator = $this->iUserRepository->validate($request->all());
            if ($validator->fails()) return response()->json(['error'=> $validator->errors()], 401);
            if(intval($userId) === 0) return response()->json(['error'=> 'O parametro não é um numero inteiro valido'], 401);

            /* todos os dados do corpo da requisição */
            $input = $request->all(); 
            /* encripta a senha */
            $input['password'] = bcrypt($input['password']); 
            /* cria o usuário */
            $success = $this->iUserRepository->update($input, $userId);

            DB::commit();
            return response()->json(['success'=> $success], $this->successStatus);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error'=> $e->message], $this->successStatus); 
        }
    }

    /**
     * Retorna o usuário
     *
     * @param  integer  $userId
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        /* verifica se o id é valido */
        if(intval($userId) === 0) return response()->json(['error'=> 'O parametro não é um numero inteiro valido'], 401);
        /* busca o usuário */
        $user = $this->iUserRepository->find($userId);
        
        return response()->json(['user'=> $user], $this->successStatus); 
    }
}