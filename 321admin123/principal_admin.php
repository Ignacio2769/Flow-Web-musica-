<?php
session_start();
include("includes/cabecera.html");
require_once("../Conexion/clases_biblioteca_multimedia.php");
require_once("../conf/constantes.php");


?>
<br/>
<br/>

<div class="c-content-box c-size-lg c-bg-grey-1">
	<div class="container" id="reproductor">

		<div id="loaddata"></div>

	</div>
</div>

<?php
include("includes/pie.html");
include("modales/modal_admin.html");
?>

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

<!--DATATABLE-->
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<!--Select2-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<!--Scripts-->

<!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

<script type="text/javascript">
	$(document).ready(function() {
		// $("#loaddata").empty();
		$("#loaddata").load("<?php echo HOST_ADMIN; ?>load/load_admin.php?accion=usuarios");
	});

	$("a[name=administrar]").click(function(){
		recargarDatos(this.id);
	});

	function recargarDatos(accion){
		$("#loaddata").load("<?php echo HOST_ADMIN; ?>load/load_admin.php?accion="+accion);
	}
</script>