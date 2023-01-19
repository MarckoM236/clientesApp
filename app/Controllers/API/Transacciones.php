<?php

namespace App\Controllers\API;

use App\Models\TransaccionModel;
use CodeIgniter\RESTful\ResourceController;


class Transacciones extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new TransaccionModel());
    }

	public function index()
	{
		$transacciones = $this->model->findAll();
        
        return $this->respond($transacciones);
   
	}

    public function create(){
        try {

            $transaccion= $this->request->getJSON();
           
            if($this->model->insert($transaccion)){
                $transaccion->id = $this->model->insertID();
                return $this->respondCreated($transaccion);
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
            
            $transaccion = $this->model->find($id);

            if($transaccion == null){
                return $this->failNotFound('No se ha encontrado una Transaccion con el ID:'.$id);
            }
            return $this->respond($transaccion);
                  

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
            
            $transaccionVerificado = $this->model->find($id);

            if($transaccionVerificado == null){
                return $this->failNotFound('No se ha encontrado una Transaccion con el ID:'.$id);
            }
            
            $transaccion= $this->request->getJSON();
           
            if($this->model->update($id,$transaccion)){
                
                return $this->respondUpdated($transaccion);
            }
                
            else{
                return $this->failValidationError($this->model->validation->listErrors());
            }
                  

        } 
        catch (\Exception $e) {

            return $this->failServerError('Ha ocurrido un error en el servidor');

        }
    }

    public function delete($id=null){
        try {

            if($id==null){
                return $this->failValidationError('No se ha pasado un ID valido');
            }
            
            $transaccionVerificado = $this->model->find($id);

            if($transaccionVerificado == null){
                return $this->failNotFound('No se ha encontrado una transaccion con el ID:'.$id);
            }
            
           
            if($this->model->delete($id)){
                
                return $this->respondDeleted($transaccionVerificado);
            }
                
            else{
                return $this->failServerError('No se ha podido eliminar el registro');
            }
                  

        } 
        catch (\Exception $e) {

            return $this->failServerError('Ha ocurrido un error en el servidor');

        }
    }
}