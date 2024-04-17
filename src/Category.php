<?php
include_once 'ConexionBD.php';

class Category {
    
    static public function getCategories() : array{
        $datos = ConexionBD::select("", "categorias", "", "", "");
        return $datos;
    }

}