<?php

namespace App\Http\Controllers\API;

use phpseclib\File\X509;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repository\ICertificateRepository;

class CertificatesController extends Controller
{
    public $iCertificateRepository;

    public function __construct(ICertificateRepository $iCertificateRepository)
	{
		$this->iCertificateRepository = $iCertificateRepository;
	}

    /**
     * Salva o certificado do usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        $data = $request->all();
        /* verifica se o certificado está no formato valido */
        if(!strpos($data['certificado']->getClientOriginalName(), '.pem')) return response()->json(['error'=> 'formato invalido'], 401); 
        DB::beginTransaction();
        try {
            $certificate = $this->iCertificateRepository->create(['data' => file_get_contents($data['certificado'])]);
            /* guarda o certificado no banco */
            $relation = $this->iCertificateRepository->relationshipUser($certificate->id, $userId);
            if($relation){
                DB::commit();
                return response()->json(['success'=> 1], 200);
            }
            return response()->json(['error'=> 'Não foi possivel salvar o certificado'], 401); 
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error'=> $e->message], 401); 
        }
    }

    /**
     * Retorna o certificado do usuário
     *
     * @param  integer  $userId
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        try {
            /* verifica se o id é valido */
            if(intval($userId) === 0) return response()->json(['error'=> 'O parametro não é um numero inteiro valido'], 401);

            $x509 = new X509();
            $certificate = $this->iCertificateRepository->certificateByUserId($userId);

            $cert = $x509->loadX509($certificate->data);

            $structureCert = ['DN' => $x509->getDN(), 'issuerDN' => $x509->getIssuerDN(), 'validity' => $cert['tbsCertificate']['validity']];
        
            return response()->json($structureCert, 200);
        } catch (\Exception $e) {
            return response()->json(['error'=> $e->message], 401);
        }

    }
}
