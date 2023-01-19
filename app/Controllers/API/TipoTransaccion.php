<?php

namespace App\Controllers\API;

use App\Models\TipoTransaccionModel;
use CodeIgniter\RESTful\ResourceController;


class TipoTransaccion extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new TipoTransaccionModel);
    }

	public function index()
	{
		$tipoTransaccion = $this->model->findAll();
        
        return $this->respond($tipoTransaccion);
   
	}

    public function create(){
        try {

            $tipTransaccion= $this->request->getJSON();
           
            if($this->model->insert($tipTransaccion)){
                $tipTransaccion->id = $this->model->insertID();
                return $this->respondCreated($tipTransaccion);
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
            
            $tipTransaccion = $this->model->find($id);

            if($tipTransaccion == null){
                return $this->failNotFound('No se ha encontrado un Tipo de Transaccion con el ID:'.$id);
            }
            return $this->respond($tipTransaccion);
                  

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
            
            $tipTransaccionVerificado = $this->model->find($id);

            if($tipTransaccionVerificado == null){
                return $this->failNotFound('No se ha encontrado un Tipo de Transaccion con el ID:'.$id);
            }
            
            $tipTransaccion= $this->request->getJSON();
           
            if($this->model->update($id,$tipTransaccion)){
                
                return $this->respondUpdated($tipTransaccion);
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
            
            $tipTransaccionVerificado = $this->model->find($id);

            if($tipTransaccionVerificado == null){
                return $this->failNotFound('No se ha encontrado un Tipo de Transaccion con el ID:'.$id);
            }
            
           
            if($this->model->delete($id)){
                
                return $this->respondDeleted($tipTransaccionVerificado);
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