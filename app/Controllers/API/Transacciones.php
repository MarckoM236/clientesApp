<?php

namespace App\Controllers\API;

use App\Models\TransaccionModel;
use App\Models\CuentaModel;
use App\Models\ClienteModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;


class Transacciones extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new TransaccionModel());
        helper('access_rol');
    }

	public function index()
	{
        $authHeader=$this->request->getServer('HTTP_AUTHORIZATION');
        
        try {
            if(!validateAccess(array('Administrador','Usuario'),$authHeader)) {
                return 
                $this->failServerError('El rol no tiene acceso a este recurso');
               }
               $transacciones = $this->model->findAll();
        
                return $this->respond($transacciones);   

        } catch (\Exception $e) {

            return $this->failServerError('Ha ocurrido un error en el servidor');

        }
   
	}

    public function create(){
        try {

            $transaccion= $this->request->getJSON();
           
            if($this->model->insert($transaccion)){
                $transaccion->id = $this->model->insertID();
                $transaccion->resultado = $this->actualizarMontoCuenta($transaccion->tipo_transaccion_id,$transaccion->monto,$transaccion->cuenta_id);
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

    public function actualizarMontoCuenta($tipoTransaccionId,$monto,$cuentaId){
        $cuentaModel=new CuentaModel();
        $cuenta=$cuentaModel->find($cuentaId);

        switch ($tipoTransaccionId){
            case 1:
                $cuenta['fondo'] += $monto;
                break;

            case 2:
                $cuenta['fondo'] -= $monto;
                break;    
        }

        if($cuentaModel->update($cuentaId,$cuenta)){
            return array('TransaccionExitosa'=> true,'NuevoFondo'=>$cuenta['fondo']);
        }
        else{
            return array('TransaccionExitosa'=> false,'NuevoFondo'=>$cuenta['fondo']);
        }
    }

    public function getTransaccionByCliente($idCliente=null){

        try {
            $clienteModel= new ClienteModel();

            if($idCliente==null){
                return $this->failValidationError('No se ha pasado un ID valido');
            }
            
            $clienteVerificado = $clienteModel->find($idCliente);

            if($clienteVerificado == null){
                return $this->failNotFound('No se ha encontrado un Cliente con el ID:'.$idCliente);
            }
            
            $transaccion= $this->model->TransaccionByCliente($idCliente);
           
            if(!$transaccion){
                
                return $this->failNotFound('No se ha encontrado una Transaccion para el cliente con el ID:'.$idCliente);
                
            }
                
            else{
                return $this->respond($transaccion);
            }
                  

        } 
        catch (\Exception $e) {

            return $this->failServerError('Ha ocurrido un error en el servidor');

        }
    }
}