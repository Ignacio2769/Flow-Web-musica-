<?php
session_start();
require_once "../Conexion/clases_biblioteca_multimedia.php";

if (isset($_REQUEST["accion"])) {
	$accion = $_REQUEST["accion"];
	$accion = strtolower($accion);
	$accion = str_replace(" ", "", $accion);

	switch ($accion) {
		case "iniciarsesion": $exito=usuario::identificar($_REQUEST["login"], md5($_REQUEST["clave"]));
		if($exito){
			$_SESSION["usuario"]=usuario::obtenerUsuario($_REQUEST["login"]);
			header("Location: ../index_usuario.php");
		}else{
			$_SESSION["errorlogin"]="ERROR";
			header("Location: ../index.php");
			// echo md5($_REQUEST["clave"]);
		}
		break;

		case "registrar": $exito=usuario::registrar($_REQUEST["nombre"], $_REQUEST["apellidos"], $_REQUEST["loginr"], md5($_REQUEST["claver"]), $_REQUEST["email"]);
		if($exito){
			//$_SESSION["usuario"]="hola";//usuario::obtenerUsuario($_REQUEST["login"]);
			header("Location: ../index.php");
		}else{
			header("Location: ../index.php");
			//$_SESSION["errorlogin"]="si";
		}
		break;
	}
}

?>