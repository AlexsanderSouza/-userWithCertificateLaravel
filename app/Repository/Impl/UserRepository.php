<?php
namespace App\Repository\Impl;

use App\Repository\IUserRepository;
use App\Repository\AbstractRepository;
use  App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserRepository extends AbstractRepository implements IUserRepository
{

	public function __construct(User $model)
	{
        $this->model = $model;
	}
    
    /**
     * Verifica se a entrada de dados corresponde a um usuário valido
     *
     * @param user $data
     * @return objetc
     */
    public function validate($data)
    {
        return Validator::make($data, [ 
                 'name'       => 'required', 
                 'email'      => 'required|email', 
                 'cpf'        => 'required', 
                 'password'   => 'required', 
                 'c_password' => 'required|same:password', 
             ]);
    }

    /**
     * retorna o usuário respectivo ao id
     *
     * @return User User
     */
    public function find($id)
    {
        $user = $this->model->find($id);
        /* traz os telefones do usuário */
        $user && $user->phones;
        return $user; 
    }


}