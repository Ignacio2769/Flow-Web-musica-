<?php
session_start();
require "../../Conexion/clases_biblioteca_multimedia.php";
require_once("../../conf/constantes.php");


if (isset($_REQUEST["accion"])) {
	$accion = $_REQUEST["accion"];
	$accion = strtolower($accion);
	$accion = str_replace(" ", "", $accion);

	switch ($accion) {
		case "usuarios": $datos=usuario::obtenerUsuarios();
		?>
		<table id="admin" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>ID_Usuario</th>
					<th>Nombre</th>
					<th>Apellidos</th>
					<th>Login</th>
					<th>Clave</th>
					<th>Email</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($datos as $keys => $values) {
					?>
					<tr>
						<td><?php echo $values["id_usuario"]; ?></td>
						<td><?php echo $values["nombre"]; ?></td>
						<td><?php echo $values["apellidos"]; ?></td>
						<td><?php echo $values["login"]; ?></td>
						<td><?php echo $values["clave"]; ?></td>
						<td><?php echo $values["email"]; ?></td>
						<td>
							<button type="button" name="borrar" id="borrar" data-toggle="modal" data-target="#modalborrar" data-datos="<?php echo $values["id_usuario"]; ?>" data-accion="borrarusuario" class="btn btn-info">
								<span class="fa fa-trash"></span>
							</button>
							<!-- <button type="button" name="borrar" id="borrar" data-toggle="modal" data-target="#modalborrar" data-datos="<?php //echo $values["email"]; ?>" data-accion="enviaremail" class="btn btn-info">
								<span class="glyphicon glyphicon-envelope"></span>
							</button> -->
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
		break;

		case "cancionesadmin": $datos=cancion::obtenerCanciones();
		?>
		<button type="button" data-toggle="modal" data-target="#subircancion" class="btn c-theme-btn" name="subircancion">Subir canción</button>
		<br/>
		<br/>
		<table id="admin" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>ID_Cancion</th>
					<th>Nombre</th>
					<th>Nombre de archivo</th>
					<th>Fecha de subida</th>
					<th>Artista</th>
					<th>ID_Categoría</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($datos as $keys => $values) {
					?>
					<tr>
						<td><?php echo $values["id_cancion"]; ?></td>
						<td><?php echo $values["nombre"]; ?></td>
						<td><?php echo $values["nombre_archivo"]; ?></td>
						<td><?php echo $values["fecha_subida"]; ?></td>
						<td><?php echo $values["artista"]; ?></td>
						<td><?php echo $values["id_categoria"]; ?></td>
						<td>
							<button type="button" name="borrar" id="borrar" data-toggle="modal" data-target="#modalborrar" data-datos="<?php echo $values["id_cancion"]; ?>" data-accion="borrarcancion" class="btn btn-info">
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

		case "playlistadmin": $datos=playlist::obtenerPlaylist();
		?>
		<table id="admin" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>ID_Playlist</th>
					<th>Nombre</th>
					<th>ID_Usuario</th>
					<th>Fecha de creación</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($datos as $keys => $values) {
					?>
					<tr>
						<td><?php echo $values["id_playlist"]; ?></td>
						<td><?php echo $values["nombre"]; ?></td>
						<td><?php echo $values["id_usuario"]; ?></td>
						<td><?php echo $values["fecha_creacion"]; ?></td>
						<td>
							<button type="button" name="borrar" id="borrar" data-toggle="modal" data-target="#modalborrar" data-datos="<?php echo $values["id_playlist"]; ?>" data-accion="borrarplaylist" class="btn btn-info">
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

		case "categoriasadmin": $datos=categoria::todasCategorias();
		?>
		<table id="admin" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>ID_Categoria</th>
					<th>Nombre</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($datos as $keys => $values) {
					?>
					<tr>
						<td><?php echo $values["id_categoria"]; ?></td>
						<td><?php echo $values["nombre"]; ?></td>
						<td>
							<button type="button" name="borrar" id="borrar" data-toggle="modal" data-target="#modalborrar" data-datos="<?php echo $values["id_categoria"]; ?>" data-accion="borrarcategoria" class="btn btn-info">
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

		case "sugerenciasadmin": $datos=sugerencia::obtenerSugerencias();
		?>
		<table id="admin" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
					<th>ID_Sugerencia</th>
					<th>ID_Usuario</th>
					<th>Sugerencia</th>
					<th>Fecha de la sugerencia</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($datos as $keys => $values) {
					?>
					<tr>
						<td><?php echo $values["id_sugerencia"]; ?></td>
						<td><?php echo $values["id_usuario"]; ?></td>
						<td><?php echo $values["sugerencia"] ?></td>
						<td><?php echo $values["fecha_sugerencia"] ?></td>
						<td>
							<button type="button" name="borrar" id="borrar" data-toggle="modal" data-target="#modalborrar" data-datos="<?php echo $values["id_sugerencia"]; ?>" data-accion="borrarsugerencia" class="btn btn-info">
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
}?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#admin').DataTable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
			}
		});
	});
</script>