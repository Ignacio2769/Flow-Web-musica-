<?php
session_start();
include("includes/cabecera.html");
require_once("Conexion/clases_biblioteca_multimedia.php");
require_once("conf/constantes.php");
//require_once "controlador/controlador.php";

?>
<br/>
<br/>

<div class="c-content-box c-size-lg c-bg-grey-1">
	<div class="container" id="reproductor">
		<?php
		$canciones=cancion::obtenerCanciones();
		?>
		<label for="">Reproduce cualquier canción:</label><br/>
		<select class="js-example-basic-single" id="canciones">
			<?php foreach ($canciones as $cancion) {
				echo "<option value='".$cancion["nombre_archivo"]."'>".$cancion["nombre"]."</option>";
			} ?>
		</select>
		<button type="button" class="btn c-theme-btn c-btn-uppercase c-btn-bold" id="reproducir">Reproducir</button>
		<br/>

		<div id="loaddata"></div>

	</div>
</div>


<?php
//include("acciones/acciones_index.php");
//echo $_SESSION["errorlogin"];
/*if(isset($_SESSION["usuario"])){
	echo $_SESSION["usuario"];
}else{
	echo "HOLASinsesion";
}*/
?>

<!--<input type="hidden" id="errorlogin" value="<?php// echo $_SESSION["errorlogin"]; ?>">-->

<?php
include("modales/modal_principal.html");
include("includes/pie.html");
?>

<!--DATATABLE-->
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<!--Select2-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>


<script type="text/javascript">
	$(document).ready(function() {
		recargarDatos();
		$(".js-example-basic-single").select2({
			width: "87%"
		});
	});

	function recargarDatos(){
		<?php

		if(isset($_SESSION["errorlogin"]) && $_SESSION["errorlogin"]=="ERROR"){
			$_SESSION["errorlogin"]="nada";	?>
			swal("Error!", "Te has equivocado introduciendo tus datos", "error");
			<?php
		}
		session_destroy();
		?>
		$("#loaddata").load("<?php echo HOST_B; ?>load/load_canciones.php");
	}

	$("#reproducir").click(function(){
	var cancion=$("#canciones").val();

	$("div.plyr--playing").empty();
	$("div.plyr--paused").empty();
	var audio=document.createElement("audio");
	audio.setAttribute("controls", "");
	audio.setAttribute("autoplay", "");
	audio.setAttribute("class", "js-player");
	var direccion=document.createElement("source");
	direccion.setAttribute("src", "CANCIONES/"+cancion);
	direccion.setAttribute("type", "audio/mp3");
	audio.appendChild(direccion);
	var reproductor=document.getElementById("reproductor");
	var referencia=document.getElementById("reproductoraqui");
	reproductor.appendChild(audio);

	//Audio
	const players = Array.from(document.querySelectorAll('.js-player')).map(player => new Plyr(player));
});

</script>