<?php

namespace App\Repository;
use  App\Models\Certificates;

interface ICertificateRepository
{
    /**
     * retorna o certificado respctivo ao id
     *
     * @return Certificates Certificates
     */
    public function find($id);

    /**
     * cria um  certificado e retorna o mesmo
     *
     * @return Certificates
     */
    public function create(array $data);

    /**
     * atualiza um  certificado e retorna o mesmo
     *
     * @return boolean
     */
    public function update(array $data, $id): bool;

    /**
     * apaga um certificado e retorna o sucesso
     *
     * @return boolean
     */
    public function delete($id): bool;

    /**
     * Relaciona certificado com o usuário
     * @param integer $certificateId
     * @param integer $userId
	 * 
     * @return boolean
     */
    public function relationshipUser($certificateId, $userId): bool;
}