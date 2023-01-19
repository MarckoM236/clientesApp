<?php
namespace App\Models\CustomRules;

use App\Models\ClienteModel;

class MyCustomRules{

    //validar si existe el cliente
    public function is_valid_cliente(int $id = null): bool
    {
        $model= new ClienteModel();

        $cliente=$model->find($id);

        return $cliente == null ? false : true;

    }
}