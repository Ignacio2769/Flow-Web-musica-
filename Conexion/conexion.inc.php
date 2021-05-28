<?php

define("HOST", "p:localhost");
define("USUARIO", "root");
define("CONTRASENA", "");
define("DB", "biblioteca_multimedia");

function conectar(){
    $conexion = new mysqli(HOST, USUARIO, CONTRASENA, DB);
    if ($conexion->connect_errno != NULL) {
        die("Error, al conectar con la base de datos:" . $conexion->connect_errno);
    }
    return $conexion;
}