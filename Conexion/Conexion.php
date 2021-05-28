<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Conexion {
    
    const host="p:localhost";
    const usuario="root";
    const password="";
    const database="world";
    
    protected static $conexion;
    
    static protected function conectar() {
        
        self::$conexion=new mysqli(self::host, self::usuario, self::password, self::database);
        if (self::$conexion->connect_errno!=0) {
            die("Error al conectar con las base de datos".self::$conexion->connect_error);
        }        
    }
    
    static protected function leer($tabla) {
                        
        $sql = "SELECT * FROM ".$tabla;
        $consulta=self::$conexion->query($sql);
        return $consulta;
    }
    
    static protected function consultarEnPor($tabla, $campo, $valor) {
                        
        $sql = "SELECT * FROM ".$tabla. " WHERE $campo = $valor";
        $consulta=self::$conexion->query($sql);
        return $consulta;
    }    

    // static function fetchArray($query = null) {
    //     $stmt = self::query($query);
    //     $a_array = array();
    //     while ($res = mysqli_fetch_array($stmt)) {
    //         $a_array[] = $res;
    //     }
    //     return $a_array;
    // }

}
