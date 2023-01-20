<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;


class Auth extends BaseController
{
    use ResponseTrait;
    public function __construct(){
        helper('secure_password');
    }
    public function index(){
        echo "Hola, Mundo";
    }

	public function login()
	{
		try {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $usuarioModel= new UsuarioModel();
            $where=['username'=>$username,'password'=>$password];

            $validateUser= $usuarioModel->where('username',$username)->first();

            if($validateUser==null){
                echo "Usuario o contrasela errada";
               return $this->failNotFound('Usuario o contrasela errada');
            }
           
            if(verifyPassword($password,$validateUser['password'])){
                //return $this->respond('usuario encontrado');
                $jwt= $this->generateJWT($validateUser);
                return $this->respond(['token' =>$jwt],201);
            }
            else{
                return $this->failValidationError('password invalido');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
	}

    protected function generateJWT($usuario){
        $key = Services::getSecretKey();
        $time=time();
        $payload = [
            "uid" => base_url(),
            "iat" => 0,
            "exp" => $time + 60,
        ];

        $jwt=JWT::encode($payload,$key,'HS256');
        return $jwt;
    }
}
