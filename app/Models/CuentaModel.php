<?php
namespace App\Models;

use CodeIgniter\Model;

class CuentaModel extends Model{
    protected $table = 'cuenta';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $allowedFields = ['moneda','fondo','cliente_id']; //campos a insertar en la DB
    
    protected $useTimestamps= true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    
    //Validaciones
    protected $validationRules = [
        'moneda' => 'required|alpha_space|min_length[3]|max_length[3]',
        'fondo' => 'required|alpha_numeric_space',
        'cliente_id' => 'required|alpha_numeric_space'
    ];

    //Mensajes personalizados para las reglas
    protected $validationMessage = [
        'cliente_id' =>[
                        //'valid_email' => 'Estimado usuario, debe ingresar un email valido'
        ]
        ];

}