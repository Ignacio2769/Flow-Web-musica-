<?php

require_once 'conexion.inc.php';

class usuario {

	static public function obtenerUsuarios() {
		$usuarios = [];
        $sql = "SELECT * FROM usuario"; //Consulta que devuelve todos los usuarios
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) { //Mientras queden tuplas crearemos el array asociativo tupla2, con los siguientes valores
        	$tupla2 = array(
        		"id_usuario" => $tupla[0],
        		"nombre" => $tupla[1],
        		"apellidos" => $tupla[2],
        		"login" => $tupla[3],
                "clave" => $tupla[4],
                "email" => $tupla[5]
            );
            array_push($usuarios, $tupla2); //E introducire cada uno en otro array, usuarios, el cual luego devolvere con json
            $tupla = $consulta->fetch_array();
        }
        return $usuarios;
    }

    static public function identificar($login, $clave){
    	$sql = "SELECT * FROM usuario";
    	$conexion = conectar();
    	$consulta = $conexion->query($sql);
    	$tupla = $consulta->fetch_array();
    	$exito = FALSE;

    	while ($tupla != null) {

    		if ($tupla["login"] == $login && $tupla["clave"] == $clave) {
    			$exito = TRUE;
    		}
    		$tupla = $consulta->fetch_array();
    	}

    	return $exito;
    }

    static public function obtenerUsuario($login){
    	$usuarios = [];
        $sql = "SELECT * FROM usuario WHERE login='$login'"; //Consulta que devuelve todos los usuarios
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        $tupla2 = array(
        	"id_usuario" => $tupla[0],
        	"nombre" => $tupla[1],
        	"apellidos" => $tupla[2],
        	"login" => $tupla[3],
        	"email" => $tupla[5]
        );
        return $tupla2;
    }

    static public function registrar($nombre, $apellidos, $login, $clave, $email){
        $sql="INSERT INTO usuario (id_usuario, nombre, apellidos, login, clave, email) VALUES(NULL, '$nombre', '$apellidos', '$login', '$clave', '$email')";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
    }

    static public function borrarusuario($id_usuario){
        $sql="DELETE FROM usuario WHERE id_usuario=$id_usuario";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}



class cancion{

	static public function obtenerCanciones() {
		$canciones = [];
        $sql = "SELECT *, (SELECT AVG(nota) FROM nota_cancion WHERE id_cancion=cancion.id_cancion) AS puntuacion FROM cancion";
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) { //Mientras queden tuplas crearemos el array asociativo tupla2, con los siguientes valores
        	$tupla2 = array(
        		"id_cancion" => $tupla[0],
                "nombre" => $tupla[1],
                "nombre_archivo" => $tupla[2],
                "fecha_subida" => $tupla[3],
                "artista" => $tupla[4],
                "id_categoria" =>$tupla[5],
                "puntuacion" => $tupla[6]
            );
            array_push($canciones, $tupla2); //E introducire cada uno en otro array, usuarios, el cual luego devolvere con json
            $tupla = $consulta->fetch_array();
        }
        return $canciones;
    }

    static public function obtenerCancionesCienMejores() {
    	$canciones = [];
        $sql = "SELECT *, (SELECT AVG(nota) FROM nota_cancion WHERE id_cancion=cancion.id_cancion) AS puntuacion FROM cancion ORDER BY puntuacion DESC LIMIT 100"; //Consulta que devuelve todos los usuarios
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) { //Mientras queden tuplas crearemos el array asociativo tupla2, con los siguientes valores
        	$tupla2 = array(
        		"id_cancion" => $tupla[0],
        		"nombre" => $tupla[1],
        		"nombre_archivo" => $tupla[2],
        		"fecha_subida" => $tupla[3],
        		"artista" => $tupla[4],
        		"id_categoria" =>$tupla[5],
        		"puntuacion" => $tupla[6]
        	);
            array_push($canciones, $tupla2); //E introducire cada uno en otro array, usuarios, el cual luego devolvere con json
            $tupla = $consulta->fetch_array();
        }
        return $canciones;
    }

    static public function obtenerCancionNombre($nombre){
        $canciones = [];
        $sql = "SELECT * FROM cancion WHERE nombre='$nombre'"; //Consulta que devuelve todos los usuarios
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) { //Mientras queden tuplas crearemos el array asociativo tupla2, con los siguientes valores
            $tupla2 = array(
                "id_cancion" => $tupla[0],
                "nombre" => $tupla[1],
                "nombre_archivo" => $tupla[2],
                "fecha_subida" => $tupla[3],
                "artista" => $tupla[4],
                "id_categoria" => $tupla[5]
            );
            array_push($canciones, $tupla2); //E introducire cada uno en otro array, usuarios, el cual luego devolvere con json
            $tupla = $consulta->fetch_array();
        }
        return $canciones;
    }

    static public function subirCancion($nombre, $artista, $nombre_archivo, $fecha_subida, $id_categoria){
        $sql="INSERT INTO cancion (id_cancion, nombre, nombre_archivo, fecha_subida, artista, id_categoria) VALUES(NULL, '$nombre', '$nombre_archivo', '$fecha_subida', '$artista', '$id_categoria')";
        $conexion = conectar();
        $consulta = $conexion->query($sql);

        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    static public function obtenerCancionUsuario($id_usuario){
        $canciones = [];
        $sql = "SELECT c.*, (SELECT AVG(nota) FROM nota_cancion WHERE id_cancion=c.id_cancion) AS puntuacion FROM cancion c LEFT JOIN cancion_usuario cu ON c.id_cancion=cu.id_cancion WHERE cu.id_usuario=$id_usuario";
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) { //Mientras queden tuplas crearemos el array asociativo tupla2, con los siguientes valores
            $tupla2 = array(
                "id_cancion" => $tupla[0],
                "nombre" => $tupla[1],
                "nombre_archivo" => $tupla[2],
                "fecha_subida" => $tupla[3],
                "artista" => $tupla[4],
                "id_categoria" =>$tupla[5],
                "puntuacion" => $tupla[6]
            );
            array_push($canciones, $tupla2); //E introducire cada uno en otro array, usuarios, el cual luego devolvere con json
            $tupla = $consulta->fetch_array();
        }
        return $canciones;
    }

    static public function obtenerCancionID($id_cancion){
        $canciones = [];
        $sql = "SELECT * FROM cancion WHERE id_cancion=$id_cancion";
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) { //Mientras queden tuplas crearemos el array asociativo tupla2, con los siguientes valores
            $tupla2 = array(
                "id_cancion" => $tupla[0],
                "nombre" => $tupla[1],
                "nombre_archivo" => $tupla[2],
                "fecha_subida" => $tupla[3],
                "artista" => $tupla[4],
                "id_categoria" =>$tupla[5]
            );
            array_push($canciones, $tupla2); //E introducire cada uno en otro array, usuarios, el cual luego devolvere con json
            $tupla = $consulta->fetch_array();
        }
        return $canciones;
    }

    static public function borrarCancionBD($id_cancion){
        $sql="DELETE FROM cancion WHERE id_cancion=$id_cancion";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}



class categoria{

	static public function obtenerCategoria($id){
		$sql="SELECT nombre FROM categoria WHERE id_categoria='$id'";
		$conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        return $tupla;
    }

    static public function obtenerCategoriaNombre($nombre){
        $sql="SELECT id_categoria FROM categoria WHERE nombre='$nombre'";
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        return $tupla;
    }

    static public function todasCategorias(){
        $categorias = [];
        $sql = "SELECT * FROM categoria"; //Consulta que devuelve todos los usuarios
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) { //Mientras queden tuplas crearemos el array asociativo tupla2, con los siguientes valores
            $tupla2 = array(
                "id_categoria" => $tupla[0],
                "nombre" => $tupla[1]
            );
            array_push($categorias, $tupla2); //E introducire cada uno en otro array, usuarios, el cual luego devolvere con json
            $tupla = $consulta->fetch_array();
        }
        return $categorias;
    }

    static public function nuevaCategoria($categoria){
        $sql="INSERT INTO categoria (id_categoria, nombre) VALUES(NULL, '$categoria')";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
    }

    static public function borrarCategoria($id_categoria){
        $sql="DELETE FROM categoria WHERE id_categoria=$id_categoria";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}



class playlist{
    static public function crearPlaylist($nombre, $id_usuario, $fecha_creacion){
        $sql="INSERT INTO playlist (id_playlist, nombre, id_usuario, fecha_creacion) VALUES(NULL, '$nombre', '$id_usuario', '$fecha_creacion')";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    static public function obtenerPlaylist(){
        $playlists = [];
        $sql = "SELECT * FROM playlist";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) {
            $tupla2 = array(
                "id_playlist" => $tupla[0],
                "nombre" => $tupla[1],
                "id_usuario" => $tupla[2],
                "fecha_creacion" => $tupla[3]
            );
            array_push($playlists, $tupla2); 
            $tupla = $consulta->fetch_array();
        }
        return $playlists;
    }

    static public function borrar_playlist($id_playlist){
        $sql="DELETE FROM playlist WHERE id_playlist='$id_playlist'";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    static public function obtenerPlaylistUsuario($id_usuario){
        $playlists = [];
        $sql = "SELECT * FROM playlist WHERE id_usuario='$id_usuario'";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) {
            $tupla2 = array(
                "id_playlist" => $tupla[0],
                "nombre" => $tupla[1],
                "id_usuario" => $tupla[2],
                "fecha_creacion" => $tupla[3]
            );
            array_push($playlists, $tupla2); 
            $tupla = $consulta->fetch_array();
        }
        return $playlists;
    }
}

class cancion_playlist{
    static public function obtenerCancionesPlaylist($id_playlist){
        $canciones = [];
        $sql = "SELECT c.*, (SELECT AVG(nota) FROM nota_cancion WHERE id_cancion=c.id_cancion) AS puntuacion FROM cancion c LEFT JOIN cancion_playlist cp ON c.id_cancion=cp.id_cancion WHERE cp.id_playlist='$id_playlist'";
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) { //Mientras queden tuplas crearemos el array asociativo tupla2, con los siguientes valores
            $tupla2 = array(
                "id_cancion" => $tupla[0],
                "nombre" => $tupla[1],
                "nombre_archivo" => $tupla[2],
                "fecha_subida" => $tupla[3],
                "artista" => $tupla[4],
                "id_categoria" => $tupla[5],
                "puntuacion" => $tupla[6]
            );
            array_push($canciones, $tupla2); //E introducire cada uno en otro array, usuarios, el cual luego devolvere con json
            $tupla = $consulta->fetch_array();
        }
        return $canciones;
    }

    static public function archivo_canciones_playlist($id_playlist){
        $canciones = [];
        $sql = "SELECT c.nombre_archivo FROM cancion c LEFT JOIN cancion_playlist cp ON c.id_cancion=cp.id_cancion WHERE cp.id_playlist='$id_playlist'";
        $conexion = conectar(); //Conectamos con la BD
        $consulta = $conexion->query($sql); //Ejecutamos la consulta
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) { //Mientras queden tuplas crearemos el array asociativo tupla2, con los siguientes valores
            $tupla2 = $tupla[0];
            array_push($canciones, $tupla2); //E introducire cada uno en otro array, usuarios, el cual luego devolvere con json
            $tupla = $consulta->fetch_array();
        }
        return json_encode($canciones);
    }

    static public function anadir_cancion_playlist($id_playlist, $id_cancion){
        $sql="INSERT INTO cancion_playlist (id_cancion_playlist, id_cancion, id_playlist) VALUES(NULL, '$id_cancion', '$id_playlist')";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    static public function borrar_playlist($id_playlist){
        $sql="DELETE FROM cancion_playlist WHERE id_playlist='$id_playlist'";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    static public function borrarCancionPlaylist($id_cancion){
        $sql="DELETE FROM cancion_playlist WHERE id_cancion='$id_cancion'";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}


class cancion_usuario{
    static public function anadirCancionUsuario($id_cancion, $id_usuario){
        $sql="INSERT INTO cancion_usuario (id_cancion_usuario, id_cancion, id_usuario) VALUES(NULL, $id_cancion, $id_usuario)";
        $conexion = conectar();
        $consulta = $conexion->query($sql);

        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    static public function borrarCancionUsuario($id_cancion){
        $sql="DELETE FROM cancion_usuario WHERE id_cancion='$id_cancion'";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}


class nota_cancion{
    static public function anadirNotaCancion($id_cancion, $id_usuario, $nota){
        $sql="INSERT INTO nota_cancion (id_nota_cancion, id_cancion, id_usuario, nota) VALUES(NULL, $id_cancion, $id_usuario, $nota)";
        $conexion = conectar();
        $consulta = $conexion->query($sql);

        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}


class sugerencia{
    static public function anadirSugerencia($id_usuario, $sugerencia, $fecha_sugerencia){
        $sql="INSERT INTO sugerencia (id_sugerencia, id_usuario, sugerencia, fecha_sugerencia) VALUES(NULL, $id_usuario, '$sugerencia', '$fecha_sugerencia')";
        $conexion = conectar();
        $consulta = $conexion->query($sql);

        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    static public function obtenerSugerencias(){
        $sugerencias = [];
        $sql = "SELECT * FROM sugerencia";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        $tupla = $consulta->fetch_array();
        while ($tupla != NULL) {
            $tupla2 = array(
                "id_sugerencia" => $tupla[0],
                "id_usuario" => $tupla[1],
                "sugerencia" => $tupla[2],
                "fecha_sugerencia" => $tupla[3]
            );
            array_push($sugerencias, $tupla2); 
            $tupla = $consulta->fetch_array();
        }
        return $sugerencias;
    }

    static public function borrarSugerencia($id_sugerencia){
        $sql="DELETE FROM sugerencia WHERE id_sugerencia='$id_sugerencia'";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        if($consulta){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}


class admin{
    static public function iniciarsesion($login, $clave){
        $sql = "SELECT * FROM admin";
        $conexion = conectar();
        $consulta = $conexion->query($sql);
        $tupla = $consulta->fetch_array();
        $exito = FALSE;

        while ($tupla != null) {

            if ($tupla["login"] == $login && $tupla["clave"] == $clave) {
                $exito = TRUE;
            }
            $tupla = $consulta->fetch_array();
        }

        return $exito;
    }
}


//Clase MP3
class MP3File
{
    protected $filename;
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public static function formatTime($duration) //as hh:mm:ss
    {
        //return sprintf("%d:%02d", $duration/60, $duration%60);
        $hours = floor($duration / 3600);
        $minutes = floor( ($duration - ($hours * 3600)) / 60);
        $seconds = $duration - ($hours * 3600) - ($minutes * 60);
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }

    //Read first mp3 frame only...  use for CBR constant bit rate MP3s
    public function getDurationEstimate()
    {
        return $this->getDuration($use_cbr_estimate=true);
    }

    //Read entire file, frame by frame... ie: Variable Bit Rate (VBR)
    public function getDuration($use_cbr_estimate=false)
    {
        $fd = fopen($this->filename, "rb");

        $duration=0;
        $block = fread($fd, 100);
        $offset = $this->skipID3v2Tag($block);
        fseek($fd, $offset, SEEK_SET);
        while (!feof($fd))
        {
            $block = fread($fd, 10);
            if (strlen($block)<10) { break; }
            //looking for 1111 1111 111 (frame synchronization bits)
            else if ($block[0]=="\xff" && (ord($block[1])&0xe0) )
            {
                $info = self::parseFrameHeader(substr($block, 0, 4));
                if (empty($info['Framesize'])) { return $duration; } //some corrupt mp3 files
                fseek($fd, $info['Framesize']-10, SEEK_CUR);
                $duration += ( $info['Samples'] / $info['Sampling Rate'] );
            }
            else if (substr($block, 0, 3)=='TAG')
            {
                fseek($fd, 128-10, SEEK_CUR);//skip over id3v1 tag size
            }
            else
            {
                fseek($fd, -9, SEEK_CUR);
            }
            if ($use_cbr_estimate && !empty($info))
            { 
                return $this->estimateDuration($info['Bitrate'],$offset); 
            }
        }
        return round($duration);
    }

    private function estimateDuration($bitrate,$offset)
    {
        $kbps = ($bitrate*1000)/8;
        $datasize = filesize($this->filename) - $offset;
        return round($datasize / $kbps);
    }

    private function skipID3v2Tag(&$block)
    {
        if (substr($block, 0,3)=="ID3")
        {
            $id3v2_major_version = ord($block[3]);
            $id3v2_minor_version = ord($block[4]);
            $id3v2_flags = ord($block[5]);
            $flag_unsynchronisation  = $id3v2_flags & 0x80 ? 1 : 0;
            $flag_extended_header    = $id3v2_flags & 0x40 ? 1 : 0;
            $flag_experimental_ind   = $id3v2_flags & 0x20 ? 1 : 0;
            $flag_footer_present     = $id3v2_flags & 0x10 ? 1 : 0;
            $z0 = ord($block[6]);
            $z1 = ord($block[7]);
            $z2 = ord($block[8]);
            $z3 = ord($block[9]);
            if ( (($z0&0x80)==0) && (($z1&0x80)==0) && (($z2&0x80)==0) && (($z3&0x80)==0) )
            {
                $header_size = 10;
                $tag_size = (($z0&0x7f) * 2097152) + (($z1&0x7f) * 16384) + (($z2&0x7f) * 128) + ($z3&0x7f);
                $footer_size = $flag_footer_present ? 10 : 0;
                return $header_size + $tag_size + $footer_size;//bytes to skip
            }
        }
        return 0;
    }

    public static function parseFrameHeader($fourbytes)
    {
        static $versions = array(
            0x0=>'2.5',0x1=>'x',0x2=>'2',0x3=>'1', // x=>'reserved'
        );
        static $layers = array(
            0x0=>'x',0x1=>'3',0x2=>'2',0x3=>'1', // x=>'reserved'
        );
        static $bitrates = array(
            'V1L1'=>array(0,32,64,96,128,160,192,224,256,288,320,352,384,416,448),
            'V1L2'=>array(0,32,48,56, 64, 80, 96,112,128,160,192,224,256,320,384),
            'V1L3'=>array(0,32,40,48, 56, 64, 80, 96,112,128,160,192,224,256,320),
            'V2L1'=>array(0,32,48,56, 64, 80, 96,112,128,144,160,176,192,224,256),
            'V2L2'=>array(0, 8,16,24, 32, 40, 48, 56, 64, 80, 96,112,128,144,160),
            'V2L3'=>array(0, 8,16,24, 32, 40, 48, 56, 64, 80, 96,112,128,144,160),
        );
        static $sample_rates = array(
            '1'   => array(44100,48000,32000),
            '2'   => array(22050,24000,16000),
            '2.5' => array(11025,12000, 8000),
        );
        static $samples = array(
            1 => array( 1 => 384, 2 =>1152, 3 =>1152, ), //MPEGv1,     Layers 1,2,3
            2 => array( 1 => 384, 2 =>1152, 3 => 576, ), //MPEGv2/2.5, Layers 1,2,3
        );
        //$b0=ord($fourbytes[0]);//will always be 0xff
        $b1=ord($fourbytes[1]);
        $b2=ord($fourbytes[2]);
        $b3=ord($fourbytes[3]);

        $version_bits = ($b1 & 0x18) >> 3;
        $version = $versions[$version_bits];
        $simple_version =  ($version=='2.5' ? 2 : $version);

        $layer_bits = ($b1 & 0x06) >> 1;
        $layer = $layers[$layer_bits];

        $protection_bit = ($b1 & 0x01);
        $bitrate_key = sprintf('V%dL%d', $simple_version , $layer);
        $bitrate_idx = ($b2 & 0xf0) >> 4;
        $bitrate = isset($bitrates[$bitrate_key][$bitrate_idx]) ? $bitrates[$bitrate_key][$bitrate_idx] : 0;

        $sample_rate_idx = ($b2 & 0x0c) >> 2;//0xc => b1100
        $sample_rate = isset($sample_rates[$version][$sample_rate_idx]) ? $sample_rates[$version][$sample_rate_idx] : 0;
        $padding_bit = ($b2 & 0x02) >> 1;
        $private_bit = ($b2 & 0x01);
        $channel_mode_bits = ($b3 & 0xc0) >> 6;
        $mode_extension_bits = ($b3 & 0x30) >> 4;
        $copyright_bit = ($b3 & 0x08) >> 3;
        $original_bit = ($b3 & 0x04) >> 2;
        $emphasis = ($b3 & 0x03);

        $info = array();
        $info['Version'] = $version;//MPEGVersion
        $info['Layer'] = $layer;
        //$info['Protection Bit'] = $protection_bit; //0=> protected by 2 byte CRC, 1=>not protected
        $info['Bitrate'] = $bitrate;
        $info['Sampling Rate'] = $sample_rate;
        //$info['Padding Bit'] = $padding_bit;
        //$info['Private Bit'] = $private_bit;
        //$info['Channel Mode'] = $channel_mode_bits;
        //$info['Mode Extension'] = $mode_extension_bits;
        //$info['Copyright'] = $copyright_bit;
        //$info['Original'] = $original_bit;
        //$info['Emphasis'] = $emphasis;
        $info['Framesize'] = self::framesize($layer, $bitrate, $sample_rate, $padding_bit);
        $info['Samples'] = $samples[$simple_version][$layer];
        return $info;
    }

    private static function framesize($layer, $bitrate,$sample_rate,$padding_bit)
    {
        if ($layer==1)
            return intval(((12 * $bitrate*1000 /$sample_rate) + $padding_bit) * 4);
        else //layer 2, 3
        return intval(((144 * $bitrate*1000)/$sample_rate) + $padding_bit);
    }
}



//Otras funciones
function subir_cancion(){
    $destino =  HOST_UP. basename($_FILES["fichero"]["name"]);

    if (move_uploaded_file($_FILES["fichero"]["tmp_name"], $destino)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function truncate($val, $f="0"){
    if(($p = strpos($val, '.')) !== false) {
        $val = floatval(substr($val, 0, $p + 1 + $f));
    }
    return $val;
}

function borrarCancion($cancion){
    if(unlink(HOST_UP.$cancion)){
        return TRUE;
    }else{
        return FALSE;
    }
}

function enviarEmail($correo){
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "ignacio3599@gmail.com";
    $to = $correo;
    $subject = "Checking PHP mail";
    $message = "PHP mail works just fine";
    $headers = "From:" . $from;
    if(mail($to,$subject,$message, $headers)){
        echo "The email message was sent.";
    }
}

function descargar($texto) {
    $informacion = pathinfo($texto);
    $nombre = $informacion["basename"];
    header('Content-Disposition: attachment; filename='.$nombre);
    header('Content-Type: audio/mpeg');
    header('Content-Length: ' . filesize(realpath($texto)));
    readfile(realpath($texto));
    exit;
}

function descargarNuevo(){
    //If the mp3 posted variable is blank or too big (hacking attempt)
    //send them to the home page...
    // if ( (!isset($_GET["mp3"])) || (strlen($_GET["mp3"]) > 100) ) {
    //     header("Location: http://www.example.com/index.php");

    // } else {
    //if there is a posted Mp3 set then do this...

    $mp3Name = trim(addslashes(strip_tags($_GET["mp3"]))); //which would be "Rom1_1.mp3"
    $filename = "Romans/$mp3Name";

    header("Content-Length: " . filesize($filename));
    header('Content-Type: audio/mpeg');
    header("Content-Disposition: attachment; filename= $mp3Name");

    readfile($filename);
}


?>