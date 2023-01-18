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

    public function edit($id=null){
        try {

            if($id==null){
                return $this->failValidationError('No se ha pasado un ID valido');
            }
            
            $cliente = $this->model->find($id);

            if($cliente == null){
                return $this->failNotFound('No se ha encontrado un cliente con el ID:'.$id);
            }
            return $this->respond($cliente);
                  

        } 
        catch (\Exception $e) {

            return $this->failServerError('Ha ocurrido un error en el servidor');

        }
    }

    public function update($id=null){
        try {

            if($id==null){
                return $this->failValidationError('No se ha pasado un ID valido');
            }
            
            $clienteVerificado = $this->model->find($id);

            if($clienteVerificado == null){
                return $this->failNotFound('No se ha encontrado un cliente con el ID:'.$id);
            }
            
            $cliente= $this->request->getJSON();
           
            if($this->model->update($id,$cliente)){
                
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