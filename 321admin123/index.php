<?php
session_start();
include("includes/cabecera.html");
require_once("../Conexion/clases_biblioteca_multimedia.php");
require_once("../conf/constantes.php");


?>
<br/>
<br/>

<!-- <div class="c-content-box c-size-lg c-bg-grey-1">
	<div class="container" id="reproductor">

		<div id="loaddata"></div>

	</div>
</div> -->
<div class="text-center">
                <a href="#myModal" class="trigger-btn" data-toggle="modal">Pulsa aquí si has cerrado el modal</a>
            </div>   

<?php
include("modales/modal_admin.html");
include("includes/pie.html");
?>

<!--DATATABLE-->
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<!--Select2-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<!--Scripts-->

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		<?php
		session_destroy();
		?>
		$("#cabecera").hide();
		$('#myModal').modal('show');
	});
</script>