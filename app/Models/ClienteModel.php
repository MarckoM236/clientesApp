<?php
namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model{
    protected $table = 'cliente';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $allowedFields = ['nombre','apellido','telefono','correo']; //campos a insertar en la DB
    
    protected $useTimestamps= true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    
    //Validaciones
    protected $validationRules = [
        'nombre' => 'required|alpha_space|min_length[3]|max_length[75]',
        'apellido' => 'required|alpha_space|min_length[3]|max_length[75]',
        'telefono' => 'required|alpha_numeric_space|min_length[8]|max_length[8]',
        'correo' => 'permit_empty|valid_email|max_length[85]'
    ];

    //Mensajes personalizados para las reglas
    protected $validationMessage = [
        'correo' =>[
                        'valid_email' => 'Estimado usuario, debe ingresar un email valido'
        ]
        ];

}