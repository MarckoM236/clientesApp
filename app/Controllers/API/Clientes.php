<?php

namespace App\Controllers\API;

use App\Models\ClienteModel;
use CodeIgniter\RESTful\ResourceController;


class Clientes extends ResourceController
{
    public function __construct(){
        $this->model = new ClienteModel();
    }

	public function index()
	{
		$clientes = $this->model->findAll();
        
        return $this->respond($clientes);
   
	}

    public function create(){
        try {

            $cliente= $this->request->getJSON();
           
            if($this->model->insert($cliente)){
                $cliente->id = $this->model->insertID();
                return $this->respondCreated($cliente);
            }
                
            else{
                return $this->failValidationError($this->model->validation->listErrors());
            }
                  

        } 
        catch (\Exception $e) {

            return $this->failServerError('Ha ocurrido un error en el servidor');

        }
        
        
    }
}