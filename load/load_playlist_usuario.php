<?php
session_start();
require "../Conexion/clases_biblioteca_multimedia.php";
require "../conf/constantes.php";
?>

<p><button type="button" class="btn c-theme-btn" id="volver_canciones">Canciones</button>
	<button type="button" class="btn c-theme-btn" id="miscanciones">Ver mis canciones</button></p>

	<?php
	if (isset($_REQUEST["accion"])) {
		$accion = $_REQUEST["accion"];
		$accion = strtolower($accion);
		$accion = str_replace(" ", "", $accion);

		switch ($accion) {
			case 'playlistusuario':

			$dato=playlist::obtenerPlaylistUsuario($_REQUEST["id_usuario"]);
			$posicion=0;
			?>

			<br/>
			<table id="playlist_usuario" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Nº Playlist</th>
						<th>Nombre</th>
						<th>Fecha de creación</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($dato as $keys => $values) {
						?>
						<tr id="<?php echo $values["id_playlist"]; ?>">
							<td><?php echo $values["id_playlist"]; ?></td>
							<td><?php echo $values["nombre"]; ?></td>
							<td><?php echo $values["fecha_creacion"];?></td>
							<td>
								<button type="button" class="btn btn-info" id="<?php echo $values["id_playlist"]; ?>" name="reproducir_playlist">
									<span class="glyphicon glyphicon-play"></span>
								</button>
								<button type="button" class="btn btn-info" id="<?php echo $values["id_playlist"]; ?>" name="confi">
									<span class="glyphicon glyphicon-cog"></span>
								</button>
								<!--<button type="button" class="btn btn-info" id="" name="borrar_playlist">
									<span class="fa fa-trash"></span>
								</button>-->
								<button type="button" name="borrar" id="borrar" data-toggle="modal" data-target="#modalborrar" data-datos="<?php echo $values["id_playlist"]; ?>" data-datos2="0" data-accion="borrar_playlist" class="btn btn-info">
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
		$dato=playlist::obtenerPlaylist();
		$posicion=0;
		?>

		<br/><br/>
		<table id="playlist_usuario" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>Playlist número</th>
					<th>Nombre</th>
					<th>Fecha de creación</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($dato as $keys => $values) {
					?>
					<tr id="<?php echo $values["id_playlist"]; ?>">
						<td><?php echo $values["id_playlist"]; ?></td>
						<td><?php echo $values["nombre"]; ?></td>
						<td><?php echo $values["fecha_creacion"];?></td>
						<td>
							<button type="button" class="btn btn-info" id="<?php echo $values["id_playlist"]; ?>" name="reproducir_playlist">
								<span class="glyphicon glyphicon-play"></span>
							</button>
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


	<script type="text/javascript">
		$(document).ready(function() {
			$('#playlist_usuario').DataTable({
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				}
			});

			$('.js-example-basic-single').select2({
				width: "80%"
			});
		});

		$("#volver_canciones").click(function(){
			$("#loaddata").empty();
			recargarDatos();
		});

		$("button[name=confi]").click(function(){
			$("#loaddata").empty();
			$("#loaddata").load("<?php echo HOST_B; ?>load/load_canciones.php?accion=canciones_playlist&playist="+this.id);
		});

		$("button[name=reproducir_playlist]").click(function(){
			var id_playlist=this.id;
			var c=0;

			$.post("acciones/acciones_index_usuario.php",
			{
				accion: "canciones_playlist",
				id_playlist: id_playlist
			}, function (resultado) {
				generarPlaylistAleatoria(resultado, Math.floor(Math.random()*(resultado.length)));
			}, "json");
		});

		function generarPlaylistAleatoria(canciones, contador){
			if(canciones.length>0){
				$("div.plyr--playing").empty();
				$("div.plyr--paused").empty();
				var audio=document.createElement("audio");
				audio.setAttribute("controls", "");
				audio.setAttribute("autoplay", "");
				audio.setAttribute("class", "js-player");
				audio.addEventListener("ended", function(){
					contador=Math.floor(Math.random()*(canciones.length));
					generarPlaylistAleatoria(canciones, contador);
				});
				var direccion=document.createElement("source");
				direccion.setAttribute("src", "CANCIONES/"+canciones[contador]);
				direccion.setAttribute("type", "audio/mp3");
				audio.appendChild(direccion);
				var reproductor=document.getElementById("reproductor");
				var referencia=document.getElementById("reproductoraqui");
				reproductor.appendChild(audio);

				//Audio
				const players = Array.from(document.querySelectorAll('.js-player')).map(player => new Plyr(player));
			}else{
				$("div.plyr--playing").empty();
				$("div.plyr--paused").empty();
				swal("Error", "Esta playlist no tiene ninguna canción que reproducir", "error");
			}
		}

		$("button[name=borrar_playlist]").click(function(){
			var id_playlist=this.id;

			$.post("acciones/acciones_index_usuario.php",
			{
				accion: "borrar_playlist",
				id_playlist: id_playlist
			}, function (resultado) {
				if(resultado){
					swal("Bien", "Eliminada", "succes");
					$("#loaddata").empty();
					$("#loaddata").load("<?php echo HOST_B; ?>load/load_playlist_usuario.php");
				}else{
					swal("Mal", "No eliminada", "error");
				}
			}, "json");
		});

		$("#miscanciones").click(function(){
			$("#loaddata").empty();
			$("#loaddata").load("<?php echo HOST_B; ?>load/load_canciones.php?accion=cancionesusuario&playist="+this.id);
		});

		function getRandomArbitrary(min, max) {
			return Math.random() * (max - min) + min;
		}

	</script>