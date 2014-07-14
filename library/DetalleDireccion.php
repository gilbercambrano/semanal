<?php
	
	include_once("Database.php") ;

	class DetalleDireccion{

		private $id 		;
		private $calle 		;
		private $numero_exterior ;
		private $numero_interior ;
		private $localidad 	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "detalles_direcciones";
		}

		function insert($detalle_direccion){     
			$sql="insert into $this->tabla values( 
				0,  
				'".$detalle_direccion['calle']."',
				'".$detalle_direccion['numero_exterior']."',
				'".$detalle_direccion['numero_interior']."',
				".$detalle_direccion['id_localidad']." 
				)";     
			mysql_query($sql, $this->conexion) ;     
			//return mysql_error() . "<br><br>".$sql;
			return mysql_insert_id(); 
			//return $sql ;
		}

		function loadById($detalle_direccion){
			$sql= "select * from $this->tabla where id_detalle_direccion=$detalle_direccion";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)){
				$row = mysql_fetch_assoc($resultado);
				$this->calle=$row['calle'];
				$this->id = $row['id_detalle_direccion'];
				$this->numero_exterior=$row['numero_exterior'];
				$this->numero_interior = $row['numero_interior'];
				$this->localidad = $row['id_localidad'];
			}
			return $sql ;
		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getCalle(){
			return $this->calle ;
		}

		function getNumeroExterior(){
			return $this->numero_exterior ;
		}

		function getNumeroInterior(){
			return $this->numero_interior ;
		}

		function getLocalidad(){
			return $this->localidad ;
		}

	}
	
?>