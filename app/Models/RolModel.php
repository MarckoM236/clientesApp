<?php
namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model{
    protected $table = 'rol';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $allowedFields = ['nombre']; //campos a insertar en la DB
    
    protected $useTimestamps= true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    
    //Validaciones
    protected $validationRules = [
        'nombre' => 'required|alpha_space|min_length[3]|max_length[45]'
    ];

    

}