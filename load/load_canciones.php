<?php
session_start();
require "../Conexion/clases_biblioteca_multimedia.php";
require_once("../conf/constantes.php");


//var_dump($dato);


if (isset($_REQUEST["accion"])) {
	$accion = $_REQUEST["accion"];
	$accion = strtolower($accion);
	$accion = str_replace(" ", "", $accion);

	switch ($accion) {
		case "canciones_playlist":
		$canciones_filtradas=cancion_playlist::obtenerCancionesPlaylist($_REQUEST["playist"]);
		$canciones=cancion::obtenerCanciones();
		$posicion=0;
		?>
		
		<select class="js-example-basic-single" name="<?php echo $_REQUEST["playist"]; ?>" id="canciones_anadir">
			<?php
			foreach ($canciones as $key => $value) {
				?>
				<option value="<?php echo $value["id_cancion"]; ?>" name="cancion"><?php echo $value["nombre"]; ?></option>
				<?php
			}
			?>
		</select>
		<button type="button" class="btn c-theme-btn" id="anadircanciones">Añadir a playlist</button>
		<br/>
		<br/>
		<table id="cienmejores" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>Posición</th>
					<th>Nombre</th>
					<th>Artista</th>
					<th>Puntuación</th>
					<th>Género</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($canciones_filtradas as $keys => $values) {
					$posicion++;
					$categoria=categoria::obtenerCategoria($values["id_categoria"]);
					?>
					<tr id="<?php echo $values["nombre_archivo"]; ?>">
						<td><?php echo $posicion; ?></td>
						<td><?php echo $values["nombre"]; ?></td>
						<td><?php echo $values["artista"]; ?></td>
						<td>
							<?php
							if(truncate($values["puntuacion"], 1)!=NULL){
								echo truncate($values["puntuacion"], 1);
							}else{
								echo "Sin calificar";
							}
							?>
						</td>
						<td>
							<?php
							if($categoria!=NULL){
								echo $categoria[0];
							}else{
								echo "Sin categoría";
							}
							?>
						</td>
						<td name="botones">
							<button type="button" name="puntuarcancion" id="<?php echo $values["id_cancion"] ?>" data-toggle="modal" data-target="#puntuarcancionmodal" data-idcancion="<?php echo $values["id_cancion"] ?>" class="btn btn-info">
								<span class="glyphicon glyphicon-pencil"></span>
							</button>
							<button type="button" value="<?php echo $_REQUEST["playist"]; ?>" name="quitar_cancion" id="<?php echo $values["id_cancion"]; ?>" class="btn btn-info">
								<span class="fa fa-trash"></span>
							</button>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
		break;

		case "cancionesusuario":
		// $canciones_filtradas=cancion_playlist::obtenerCancionesPlaylist($_REQUEST["playist"]);
		$canciones=cancion::obtenerCancionUsuario($_SESSION["usuario"]["id_usuario"]);
		$posicion=0;
		?>
		<button type="button" data-toggle="modal" data-target="#subircancion" class="btn c-theme-btn" name="subircancion">Subir canción</button>

		<button type="button" class="btn c-theme-btn" id="explorar" name="accion" value="explorarplaylist">Explorar Playlists</button>
		<br/>
		<br/>
		<table id="cienmejores" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>Posición</th>
					<th>Nombre</th>
					<th>Artista</th>
					<th>Puntuación</th>
					<th>Género</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($canciones as $keys => $values) {
					$posicion++;
					$categoria=categoria::obtenerCategoria($values["id_categoria"]);
					?>
					<tr id="<?php echo $values["id_cancion"]; ?>" name="<?php echo $values["nombre_archivo"]; ?>">
						<td><?php echo $posicion; ?></td>
						<td><?php echo $values["nombre"]; ?></td>
						<td><?php echo $values["artista"]; ?></td>
						<td>
							<?php
							if(truncate($values["puntuacion"], 1)!=NULL){
								echo truncate($values["puntuacion"], 1);
							}else{
								echo "Sin calificar";
							}
							?>
						</td>
						<td>
							<?php
							if($categoria!=NULL){
								echo $categoria[0];
							}else{
								echo "Sin categoría";
							}
							?>
						</td>
						<td name="botones">
							<button type="button" class="btn btn-info" id="<?php echo $values["nombre_archivo"]; ?>" name="reproducir_cancion">
								<span class="glyphicon glyphicon-play"></span>
							</button>
							<button type="button" name="puntuarcancion" id="<?php echo $values["id_cancion"] ?>" data-toggle="modal" data-target="#puntuarcancionmodal" data-idcancion="<?php echo $values["id_cancion"] ?>" class="btn btn-info">
								<span class="glyphicon glyphicon-pencil"></span>
							</button>
							<button type="button" name="borrar" id="borrar" data-toggle="modal" data-target="#modalborrar" data-datos="<?php echo $values["id_cancion"]; ?>" data-datos2="<?php echo $values["nombre_archivo"]; ?>" data-accion="borrarcancion" class="btn btn-info">
								<span class="fa fa-trash"></span>
							</button>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
		break;
	}
}else{
	$posicion=0;
	
	if(isset($_SESSION["usuario"])){
		$dato=cancion::obtenerCanciones();
		?>
		<button type="button" data-toggle="modal" data-target="#subircancion" class="btn c-theme-btn" name="subircancion">Subir canción</button>

		<button type="button" class="btn c-theme-btn" id="explorar" name="accion" value="explorarplaylist">Explorar Playlists</button>
		<?php
	}else{
		$dato=cancion::obtenerCancionesCienMejores();
	}
	?>
	<br/>
	<br/>
	<table id="cienmejores" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th>Posición</th>
				<th>Nombre</th>
				<th>Artista</th>
				<th>Puntuación</th>
				<th>Género</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($dato as $keys => $values) {
				$posicion++;
				$categoria=categoria::obtenerCategoria($values["id_categoria"]);
				?>
				<tr id="<?php echo $values["nombre_archivo"]; ?>">
					<td><?php echo $posicion; ?></td>
					<td><?php echo $values["nombre"]; ?></td>
					<td><?php echo $values["artista"]; ?></td>
					<td>
						<?php
						if(truncate($values["puntuacion"], 1)!=NULL){
							echo truncate($values["puntuacion"], 1);
						}else{
							echo "Sin calificar";
						}
						?>
					</td>
					<td>
						<?php
						if($categoria!=NULL){
							echo $categoria[0];
						}else{
							echo "Sin categoría";
						}
						?>
					</td>
					<td name="botones">
						<button type="button" class="btn btn-info" id="<?php echo $values["nombre_archivo"]; ?>" name="reproducir_cancion">
							<span class="glyphicon glyphicon-play"></span>
						</button>
						<?php if(isset($_SESSION["usuario"])){ ?>
							<button type="button" name="puntuarcancion" id="<?php echo $values["id_cancion"] ?>" data-toggle="modal" data-target="#puntuarcancionmodal" data-idcancion="<?php echo $values["id_cancion"] ?>" class="btn btn-info">
								<span class="glyphicon glyphicon-pencil"></span>
							</button>
							<button type="button" class="btn btn-info" id="<?php echo $values["nombre_archivo"]; ?>" name="descargar">
								<span class="glyphicon glyphicon-cloud-download"></span>
							</button>
						<?php } ?>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<?php
}
?>

<!--Select2-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<!--SweetAlert-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#cienmejores').DataTable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
			}
		});

		$('.js-example-basic-single').select2({
			width: "87%"
		});
	});

	$("button[name=reproducir_cancion]").click(function(){
		$("div.plyr--playing").empty();
		$("div.plyr--paused").empty();
		var audio=document.createElement("audio");
		audio.setAttribute("controls", "");
		audio.setAttribute("autoplay", "");
		audio.setAttribute("class", "js-player");
		var direccion=document.createElement("source");
		direccion.setAttribute("src", "CANCIONES/"+this.id);
		direccion.setAttribute("type", "audio/mp3");
		audio.appendChild(direccion);
		var reproductor=document.getElementById("reproductor");
		var referencia=document.getElementById("reproductoraqui");
		reproductor.appendChild(audio);

		//Audio
		const players = Array.from(document.querySelectorAll('.js-player')).map(player => new Plyr(player));
	});

	$("#anadircanciones").click(function(){
		var cancion=document.getElementById("canciones_anadir");
		//alert("id_cancion: "+cancion.value+" name: "+cancion.name);

		$.post("acciones/acciones_index_usuario.php",
		{
			accion: "anadircancionplaylist",
			id_playlist: cancion.name,
			id_cancion: cancion.value
		}, function (resultado) {
			if(resultado){
				swal("Enhorabuena!", "Se añadió la canción correctamente", "success");
				$("#loaddata").empty();
				$("#loaddata").load("<?php echo HOST_B; ?>load/load_canciones.php?accion=canciones_playlist&playist="+cancion.name);
			}else{
				swal("Error!", "No se pudo añadir la canción", "error");
			}
		}, "json");
	});

	$("#explorar").click(function(){
		$("#loaddata").empty();
		$("#loaddata").load("<?php echo HOST_B; ?>load/load_playlist_usuario.php");
	});

	$("button[name=descargar]").click(function(){
		url="CANCIONES/"+this.id;
		var filename = url.substring(url.lastIndexOf("/") + 1).split("?")[0];
		var xhr = new XMLHttpRequest();
		xhr.responseType = 'blob';
		xhr.onload = function() {
			var a = document.createElement('a');
			a.href = window.URL.createObjectURL(xhr.response);
			a.download = filename; 
			a.style.display = 'none';
			document.body.appendChild(a);
			a.click();
			delete a;
		};
		xhr.open('GET', url);
		xhr.send();
	});

	$("button[name=quitar_cancion]").click(function(){
		// alert(this.value);
		var playlist=this.value;
		var id_cancion=this.id;
		$.post("acciones/acciones_index_usuario.php",
		{
			accion: "quitarcancionplaylist",
			id_cancion: id_cancion
		}, function (resultado) {
			if(resultado){
				swal("Enhorabuena!", "Se eliminado la canción de tu playlist", "success");
				$("#loaddata").empty();
				$("#loaddata").load("<?php echo HOST_B; ?>load/load_canciones.php?accion=canciones_playlist&playist="+playlist);
			}else{
				swal("Error!", "No se pudo eliminar la canción de tu playlist", "error");
			}
		}, "json");
	});

</script>