<?php
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RolModel;

function validateAccess($roles,$authHeader){
    if(!is_array($roles)){
        return false;
    }

    $key= Services::getSecretKey();

    $arr = explode(' ',$authHeader);
    $jwt = $arr[1];
    //print_r($jwt);
    $jwtDecoded=JWT::decode($jwt, new Key($key, 'HS256'));
    //print_r($jwtDecoded->data->rol);
    $rolModel = new RolModel();
    $rol= $rolModel->find($jwtDecoded->data->rol);

    if($rol == null){
        return false;
    }

    if(!in_array($rol["nombre"],$roles)){
        return false;
    }

    return true;
}