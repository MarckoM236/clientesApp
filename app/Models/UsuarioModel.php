<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
    protected $table = 'usuario';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $allowedFields = ['nombre','username','password','rol_id']; //campos a insertar en la DB
    
    protected $useTimestamps= true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    
    //Validaciones
    protected $validationRules = [
        'nombre' => 'required|alpha_space|min_length[3]|max_length[75]',
        'username' => 'required|alpha_space|min_length[3]|max_length[75]',
        'password' => 'required|alpha_space',
        'rol_id' => 'required|integer'
    ];

    

}