<?php

namespace App\Repository;
use  App\Models\User;

interface IUserRepository
{
    /**
     * retorna o usuário respctivo ao id
     *
     * @return User User
     */
    public function find($id);

    /**
     * retorna todos os usuários cadastrados
     *
     * @return Object User
     */
    public function findAll();

    /**
     * cria um  usuário e retorna o mesmo
     *
     * @return User
     */
    public function create(array $data);

    /**
     * atualiza um  usuário e retorna o mesmo
     *
     * @return boolean
     */
    public function update(array $data, $id): bool;

    /**
     * busca ou cria um usuário e retorna o mesmo
     *
     * @return User
     */
    public function firstOrCreate(array $data);

    /**
     * apaga um usuário e retorna o sucesso
     *
     * @return boolean
     */
    public function delete($id): bool;

    /**
     * Verifica se a entrada de dados corresponde a um usuário valido
     *
     * @param User $data
     * @return objetc
     */
    public function validate($data);
}