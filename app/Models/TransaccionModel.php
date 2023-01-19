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
        'cuenta_id' => 'required',
        'tipo_transaccion_id' => 'required',
        'monto' => 'required|alpha_numeric_space'
    ];

    
}