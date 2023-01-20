<?php
namespace App\Models;

use CodeIgniter\Model;

class TransaccionModel extends Model{
    protected $table = 'transaccion';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $allowedFields = ['cuenta_id','tipo_transaccion_id','monto']; //campos a insertar en la DB
    
    protected $useTimestamps= true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    
    //Validaciones
    protected $validationRules = [
        'cuenta_id' => 'required|integer',
        'tipo_transaccion_id' => 'required|integer',
        'monto' => 'required|alpha_numeric_space'
    ];

    public function TransaccionByCliente($idCliente=null){
        $builder = $this->db->table($this->table);
        $builder->select('cliente.nombre,cliente.apellido,cuenta.id AS NumeroCuenta');
        $builder->select('tipo_transaccion.descripcion AS tipo, transaccion.monto, transaccion.created_at AS FechaTransaccion');
        $builder->join('cuenta','transaccion.cuenta_id = cuenta.id');
        $builder->join('tipo_transaccion','transaccion.tipo_transaccion_id = tipo_transaccion.id');
        $builder->join('cliente','cuenta.cliente_id = cliente.id');
        $builder->where('cliente.id',$idCliente);

        $query = $builder->get();

        return $query->getResult();
    }

    
}