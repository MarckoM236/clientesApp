<?php
namespace App\Models;

use CodeIgniter\Model;

class TipoTransaccionModel extends Model{
    protected $table = 'tipo_transaccion';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $allowedFields = ['descripcion']; //campos a insertar en la DB
    
    protected $useTimestamps= true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    
    //Validaciones
    protected $validationRules = [
        'descripcion' => 'required|alpha_space|min_length[3]|max_length[65]'
    ];

}