<?php
session_start();
require_once "../Conexion/clases_biblioteca_multimedia.php";
require_once "../conf/constantes.php";

if (isset($_REQUEST["accion"])) {
	$accion = $_REQUEST["accion"];
	$accion = strtolower($accion);
	$accion = str_replace(" ", "", $accion);

	switch ($accion) {
		case "crearplaylist": $exito=playlist::crearPlaylist($_REQUEST["nombre"], $_SESSION["usuario"]["id_usuario"], date('Y-m-d'));
		if($exito){
			$_SESSION["error"]="CORRECTO";
			header("Location: ../index_usuario.php");
		}else{
			$_SESSION["error"]="ERROR";
			header("Location: ../index_usuario.php");
		}
		break;

		case "canciones_playlist": $canciones=cancion_playlist::archivo_canciones_playlist($_REQUEST["id_playlist"]);
		echo $canciones;
		break;

		case "anadircancionplaylist": $exito=cancion_playlist::anadir_cancion_playlist($_REQUEST["id_playlist"], $_REQUEST["id_cancion"]);
		echo json_encode($exito);
		break;

		case "cerrasesion": session_destroy();
		header("Location: ../index.php");
		break;

		case "borrar_playlist": 
		$exito=playlist::borrar_playlist($_REQUEST["datos"]);
		if($exito){
			$exito=cancion_playlist::borrar_playlist($_REQUEST["datos"]);
			$_SESSION["error"]="CORRECTO";
		}else{
			$_SESSION["error"]="ERROR";
		}
		header("Location: ../index_usuario.php");
		break;

		case "subircancion": $categoria=categoria::obtenerCategoriaNombre($_REQUEST["categoria"]);
		if($categoria["id_categoria"]==""){
			categoria::nuevaCategoria($_REQUEST["categoria"]);
			$categoria=categoria::obtenerCategoriaNombre($_REQUEST["categoria"]);
		}

		if($_FILES["fichero"]["type"]=="audio/mp3"){
			$exito=cancion::subirCancion(explode(".", $_FILES["fichero"]["name"])[0], $_REQUEST["artista"], $_FILES["fichero"]["name"], date('Y-m-d H:i:s'), $categoria[0]);

			$exito2=FALSE;
			if($exito){
				$id_cancion=cancion::obtenerCancionNombre(explode(".", $_FILES["fichero"]["name"])[0]);

				if(isset($_SESSION["usuario"]["id_usuario"])){
					$iduser=$_SESSION["usuario"]["id_usuario"];
					$locatio="Location: ../index_usuario.php";
				}else{
					$iduser=0;
					$locatio="Location: ../321admin123/principal_admin.php";
				}
				$exito2=cancion_usuario::anadirCancionUsuario($id_cancion[0]["id_cancion"], $iduser);
			}else{
				if(isset($_SESSION["usuario"]["id_usuario"])){
					$locatio="Location: ../index_usuario.php";
				}else{
					$locatio="Location: ../321admin123/principal_admin.php";
				}
			}

			if($exito2){
				$destino = HOST_UP . basename($_FILES["fichero"]["name"]);
				if(move_uploaded_file($_FILES["fichero"]["tmp_name"], $destino)){
					$_SESSION["error"]="CORRECTO";
					header($locatio);
				}
			}else{
				$_SESSION["error"]="ERROR";
				header($locatio);
			}

		}else{
			$_SESSION["error"]="ERROR";
			header("Location: ../index_usuario.php");
		}
		break;

		case "puntuarcancion": $exito=nota_cancion::anadirNotaCancion($_REQUEST["id_cancion"], $_SESSION["usuario"]["id_usuario"], $_REQUEST["nota"]);

		if($exito){
			$_SESSION["error"]="CORRECTO";
			header("Location: ../index_usuario.php");
		}else{
			$_SESSION["error"]="ERROR";
			header("Location: ../index_usuario.php");
		}
		break;

		case "sugerencia":
		if(isset($_SESSION["usuario"])){
			$id_usuario=$_SESSION["usuario"]["id_usuario"];
			$redire="Location: ../index_usuario.php";
		}else{
			$id_usuario=-1;
			$redire="Location: ../index.php";
		}
		$exito=sugerencia::anadirSugerencia($id_usuario, $_REQUEST["sugerenciauser"], date('Y-m-d'));

		if($exito){
			$_SESSION["error"]="CORRECTO";
			header($redire);
		}else{
			$_SESSION["error"]="ERROR";
			header($redire);
		}
		break;

		case "borrarcancion": $exito=borrarCancion($_REQUEST["datos2"]);
		if($exito){
			$exito2=cancion::borrarCancionBD($_REQUEST["datos"]);

			if($exito2){
				$exito3=cancion_usuario::borrarCancionUsuario($_REQUEST["datos"]);

				if($exito3){
					$exito4=cancion_playlist::borrarCancionPlaylist($_REQUEST["datos"]);
					$_SESSION["error"]="CORRECTO";
					header("Location: ../index_usuario.php");
				}else{
					$_SESSION["error"]="ERROR";
					header("Location: ../index_usuario.php");
				}
			}else{
				$_SESSION["error"]="ERROR";
				header("Location: ../index_usuario.php");
			}
		}else{
			$_SESSION["error"]="ERROR";
			header("Location: ../index_usuario.php");
		}
		break;

		case "descargar": $exito=descargar($_REQUEST["ruta"]);
		echo json_encode($exito);
		break;

		case "quitarcancionplaylist": $exito=cancion_playlist::borrarCancionPlaylist($_REQUEST["id_cancion"]);
		echo json_encode($exito);
		break;
	}
}
?>