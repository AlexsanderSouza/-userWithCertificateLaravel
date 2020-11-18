<?php
namespace App\Repository\Impl;

use  App\Models\Certificates;
use App\Repository\IUserRepository;
use App\Repository\AbstractRepository;
use App\Repository\ICertificateRepository;

class CertificateRepository extends AbstractRepository implements ICertificateRepository
{
	public $iUserRepository;

	public function __construct(Certificates $model, IUserRepository $iUserRepository)
	{
		$this->model = $model;
		$this->iUserRepository = $iUserRepository;
	}

	/**
     * Relaciona certificado com o usuário
     * @param integer $certificateId
     * @param integer $userId
	 * 
     * @return boolean
     */
    public function relationshipUser($certificateId, $userId): bool
    {
		/* busca o usuário */
		// $model = $this->iUserRepository->find($userId);
		/* relaciona o certificado como usuário */
		$update = $this->iUserRepository->update(['certificate_id' => $certificateId], $userId);
        return $update;
	}
	
	/**
     * busca o certificado do usuário
     * @param integer $userId
	 * 
     * @return Certificates
     */
    public function certificateByUserId($userId): Certificates
    {
		/* busca o usuário */
		$user = $this->iUserRepository->find($userId);
		$user && $certificate = $user->certificate;

        return $certificate ?? new Certificates;
    }
}