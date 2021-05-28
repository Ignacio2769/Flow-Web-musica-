<?php
session_start();
include("includes/cabecera_usuario.html");
require_once("Conexion/clases_biblioteca_multimedia.php");
require_once("conf/constantes.php");

?>
<br/>
<br/>

<div class="c-content-box c-size-lg c-bg-grey-1">
	<div class="container" id="reproductor">
		<div id="loaddata"></div>
	</div>
</div>

<?php

// echo file_get_contents("letra.txt");

include("includes/pie.html");
include("modales/modal_usuario.html");

?>

<!--DATATABLE-->
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<!--Select2-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<!--SweetAlert-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php if(isset($_SESSION["error"]) && $_SESSION["error"]=="ERROR"){
	$_SESSION["error"]="nada";	?>
	<script type="text/javascript">
		swal("Error!", "No se pudo completar la acción deseada", "error");
		</script> <?php
	}else if(isset($_SESSION["error"]) && $_SESSION["error"]=="CORRECTO"){
		$_SESSION["error"]="nada";	?>
		<script type="text/javascript">
			swal("Enhorabuena!", "No ocurrió ningún error", "success");
			</script> <?php
		} ?>

		<script type="text/javascript">
			$(document).ready(function() {
				recargarDatos();
		//swal("Good job!", "You clicked the button!", "success");
	});

		function recargarDatos(){
			$("#loaddata").load("<?php echo HOST_B; ?>load/load_canciones.php");
		}

	// $("#boton_crearplaylist").click(function(){

	// 	$('#crearplaylist').on('show.bs.modal', function() {
	// 		$('#select2-sample').select2();
	// 	});

	// 	$('#crearplaylist').on('hidden.bs.modal', function() {
	// 		$('#select2-sample').select2('destroy');
	// 	});
	// });

	$("#misplaylist").click(function(){
		$("#loaddata").empty();
		$("#loaddata").load("<?php echo HOST_B; ?>load/load_playlist_usuario.php?accion=playlistusuario&id_usuario="+this.name);
	});

	$('#puntuarcancionmodal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var id_cancion = button.data('idcancion');
		alert("id_cancion");
	});
	
</script>