<?php

	include_once("Database.php");

	class Usuario{

		private $id 			;
		private $username 		;
		private $password 		;
		private $tipo_usuario 	;
		private $estatus 		;
		private $empleado 		;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "usuarios";
		}

		function insert($usuario){
			$sql = "insert into usuario values(
				0, 
				'".$usuario['username']."',
				'".$usuario['password']."',
				'".$usuario['tipo_usuario']."',
				'ACTIVO',
				".$usuario['id_empleado']."
				)";
			return mysql_query($sql, $this->conexion);
		}

		function loadByUsername($usuario){
			$sql = "select * from $this->tabla where estatus='ACTIVO' and username = '".$usuario."'";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado) > 0){
				$row = mysql_fetch_assoc($resultado) ;
				$this->id = $row['id_usuario'] ;
				$this->username = $row['username'] ;
				$this->password = $row['password'] ;
				$this->tipo_usuario = $row['tipo_usuario'] ;
				$this->estatus = $row['estatus'] ;
				$this->empleado = $row['id_empleado'] ;
			}

			return mysql_num_rows($resultado) ;
		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getUsername(){
			return $this->username ;
		}

		function getPassword(){
			return $this->password ;
		}

		function getTipoUsuario(){
			return $this->tipo_usuario ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getEmpleado(){
			return $this->empleado ;
		}

	}

?>