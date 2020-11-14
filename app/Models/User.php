<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Os atributos que podem ser atribuídos
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf',
        'email',
        'yearbirth',
        'password',
        'adress',
        'phones_id',
        'certificates_id',
    ];

    /**
     * Os atributos que devem ser ocultados
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Os atributos que devem ser convertidos em tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Valida um usuário
     *
     * @param user $data
     * @return void
     */
    public static function validate($data){
       return Validator::make($data, [ 
                'name'       => 'required', 
                'email'      => 'required|email', 
                'cpf'        => 'required', 
                'password'   => 'required', 
                'c_password' => 'required|same:password', 
            ]);
    }
}
