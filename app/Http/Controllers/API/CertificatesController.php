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
     * obtem uma lista de usuários
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $x509 = new X509();
        $certificate = $this->iCertificateRepository->find(5);
        $cert = $x509->loadX509($certificate->data);

        dd($cert, $x509->getDN(), $x509->getIssuerDN(),$x509->validateSignature(), $x509->validateDate(), 123);
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
            dd($e);
            return response()->json(['error'=> $e->message], 401); 
        }
    }
}
