<?php

namespace App\Repository;
use  App\Models\User;

interface IUserRepository
{
    /**
     * retorna o usuário respctivo ao id
     *
     * @return array user
     */
    public function find($id);

    /**
     * retorna todos os usuários cadastrados
     *
     * @return array user
     */
    public function findAll();

    /**
     * cria um  usuário e retorna o mesmo
     *
     * @return user
     */
    public function create(array $data);

    /**
     * atualiza um  usuário e retorna o mesmo
     *
     * @return user
     */
    public function update(array $data, $id);

    /**
     * busca ou cria um usuário e retorna o mesmo
     *
     * @return user
     */
    public function firstOrCreate(array $data);

    /**
     * apaga um usuário e retorna o sucesso
     *
     * @return user
     */
    public function delete($id);

    /**
     * Verifica se a entrada de dados corresponde a um usuário valido
     *
     * @param user $data
     * @return objetc
     */
    public function validate($data);
}