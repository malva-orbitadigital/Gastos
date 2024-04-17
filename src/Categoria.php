<?php
include_once 'ConexionBD.php';

class Categoria {
    
    static public function getCategorias() : array{
        $datos = ConexionBD::select("nombre", "categorias", "", "", "");
        return $datos;
    }

}