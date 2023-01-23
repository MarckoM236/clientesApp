<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface{

    use ResponseTrait;

    //Se ejecuta antes del controlador
    public function before(RequestInterface $request,$arguments=null){

        try {
            $key= Services::getSecretKey();
            $authHeader=$request->getServer('HTTP_AUTHORIZATION');

            if($authHeader == null){
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED,'No se ha enviado el JWT Requerido');
            }
            $arr = explode(' ',$authHeader);
            $jwt = $arr[1];
            //print_r($jwt);
            $decoded=JWT::decode($jwt, new Key($key, 'HS256'));
        } catch(ExpiredException $ee){
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED,'El Token JWT ha expirado');
        } 
        
        catch (Exception $ex) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,'Ocurrio un error en el servidor al validar el Token');
        }
    }

    //Se ejecuta despues del controlador
    public function after(RequestInterface $request,ResponseInterface $response,$arguments=null){

    }
}