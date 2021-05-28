<?php
session_start();
require_once "../../Conexion/clases_biblioteca_multimedia.php";
require_once "../../conf/constantes.php";

if (isset($_REQUEST["accion"])) {
	$accion = $_REQUEST["accion"];
	$accion = strtolower($accion);
	$accion = str_replace(" ", "", $accion);

	switch ($accion) {
		case "iniciarsesion": $exito=admin::iniciarsesion($_REQUEST["admin"], $_REQUEST["clave"]);
		if ($exito) {
			header("Location: ../principal_admin.php");
		}else{
			header("Location: ../index.php");
		}
		break;

		case "borrarusuario": $exito=usuario::borrarusuario($_REQUEST["datos"]);
		if($exito){
			$_SESSION["error"]="CORRECTO";
			header("Location: ../principal_admin.php");
		}else{
			$_SESSION["error"]="ERROR";
			header("Location: ../principal_admin.php");
		}

		case "borrarcancion": $datos=cancion::obtenerCancionID($_REQUEST["datos"]);
		if($datos!=NULL){
			$exito=borrarCancion($datos[0]["nombre_archivo"]);
			if($exito){
				$exito2=cancion::borrarCancionBD($_REQUEST["datos"]);

				if($exito2){
					$exito3=cancion_usuario::borrarCancionUsuario($_REQUEST["datos"]);

					if($exito3){
						$exito4=cancion_playlist::borrarCancionPlaylist($_REQUEST["datos"]);
						$_SESSION["error"]="CORRECTO";
						header("Location: ../principal_admin.php");
					}else{
						$_SESSION["error"]="ERROR";
						header("Location: ../principal_admin.php");
					}
				}else{
					$_SESSION["error"]="ERROR";
					header("Location: ../principal_admin.php");
				}
			}else{
				$_SESSION["error"]="ERROR";
				header("Location: ../principal_admin.php");
			}
		}
		break;

		case "borrarplaylist": $exito=playlist::borrar_playlist($_REQUEST["datos"]);
		if($exito){
			$exito2=cancion_playlist::borrar_playlist($_REQUEST["datos"]);
			if($exito2){
				$_SESSION["error"]="CORRECTO";
			}else{
				$_SESSION["error"]="ERROR";
			}
		}
		header("Location: ../principal_admin.php");
		break;

		case "borrarcategoria": $exito=categoria::borrarCategoria($_REQUEST["datos"]);
		if($exito){
			$_SESSION["error"]="CORRECTO";
			header("Location: ../principal_admin.php");
		}else{
			$_SESSION["error"]="ERROR";
			header("Location: ../principal_admin.php");
		}
		break;

		case "borrarsugerencia": sugerencia::borrarSugerencia($_REQUEST["datos"]);
		$_SESSION["error"]="CORRECTO";
		header("Location: ../principal_admin.php");
		break;

		// case "enviaremail": enviarEmail("BIEN");
		// header("Location: ../principal_admin.php");
		// break;
	}
}