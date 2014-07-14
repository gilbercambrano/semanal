<?php

	include_once("Database.php");

	class Empleado{

		private $id 			;
		private $nombre 		;
		private $apellido_paterno ;
		private $apellido_materno ;
		private $fecha_nacimiento ;
		private $curp 			;
		private $ife 			;
		private $matricula_smn 	;
		private $tipo_sangre 	;
		private $licencia 		;
		private $telefono_fijo 	;
		private $telefono_movil ;
		private $email 			;
		private $fecha_inicio 	;
		private $observaciones	;
		private $curriculum 	;
		private $foto 			;
		private $numero_imss 	;
		private $estatus 		;
		private $fecha_fin		;
		private $detalle_direccion ;
		private $clinica		;
		private $cuenta_bancaria ;
		private $sexo 			;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "empleados";
		}

		function insert($empleado){
			$sql = "insert into $this->tabla values(
				0,
				'".$empleado['nombre']."',
				'".$empleado['apellido_paterno']."',
				'".$empleado['apellido_materno']."',
				'".$empleado['fecha_nacimiento']."',
				'".$empleado['curp']."',
				'".$empleado['ife']."',
				'".$empleado['matricula_smn']."',
				'".$empleado['tipo_sangre']."',
				'".$empleado['licencia']."',
				'".$empleado['telefono_fijo']."',
				'".$empleado['telefono_movil']."',
				'".$empleado['email']."',
				'".$empleado['fecha_inicio']."',
				'".$empleado['sexo']."',
				'".$empleado['observaciones']."',
				'".$empleado['curriculum']."',
				'".$empleado['foto']."',
				'".$empleado['numero_imss']."',
				'".$empleado['estatus']."',
				'".$empleado['fecha_fin']."',
				".$empleado['id_detalle_direccion'].",
				".$empleado['id_clinica'].",
				".$empleado['id_cuenta_bancaria']."
				)";
		mysql_query($sql, $this->conexion);

			return mysql_insert_id();
			//return mysql_error() . "<br><br>" .$sql ;
		}

		function insertTemp($empleado){
			$sql = "insert into $this->tabla values(
				0,
				'".$empleado['nombre']."',
				'".$empleado['apellido_paterno']."',
				'".$empleado['apellido_materno']."',
				'".$empleado['fecha_nacimiento']."',
				'".$empleado['curp']."',
				'".$empleado['ife']."',
				'".$empleado['matricula_smn']."',
				'".$empleado['tipo_sangre']."',
				'".$empleado['licencia']."',
				'".$empleado['telefono_fijo']."',
				'".$empleado['telefono_movil']."',
				'".$empleado['email']."',
				'".$empleado['fecha_inicio']."',
				'".$empleado['sexo']."',
				'".$empleado['observaciones']."',
				'',
				'',
				'',
				'LABORANDO',
				'0000-00-00',
				1,
				951,
				".$empleado['id_cuenta_bancaria']."
				)";
		mysql_query($sql, $this->conexion);

			return mysql_insert_id();
			//return mysql_error() . "<br><br>" .$sql ;
		}


		function delete($empleado){
			$sql = "update $this->tabla set estatus = 'CANCELADO' where id_empleado = $empleado" ;
			mysql_query($sql, $this->conexion);
		}

		function updateEstatus($empleado, $estatus){
			$sql = "update $this->tabla set estatus = '".$estatus."' where id_empleado = $empleado" ;
			mysql_query($sql, $this->conexion);
		}

		function update($empleado){
			$sql = "update $this->tabla set 
				
				nombre = '".$empleado['nombre']."',
				apellido_paterno='".$empleado['apellido_paterno']."',
				apellido_materno='".$empleado['apellido_materno']."',
				fecha_nacimiento='".$empleado['fecha_nacimiento']."',
				curp='".$empleado['curp']."',
				ife='".$empleado['ife']."',
				matricula_smn='".$empleado['matricula_smn']."',
				tipo_sangre='".$empleado['tipo_sangre']."',
				licencia='".$empleado['licencia']."',
				telefono_fijo='".$empleado['telefono_fijo']."',
				telefono_movil='".$empleado['telefono_movil']."',
				email='".$empleado['email']."',
				fecha_inicio='".$empleado['fecha_inicio']."',
				sexo='".$empleado['sexo']."',
				observaciones='".$empleado['observaciones']."'
				
				where id_empleado = ".$empleado['id_empleado']."
				";
		mysql_query($sql, $this->conexion);

			
			return $sql ;
		}

		function getCompaniaEmpleado($empleado){
			$sql = "select 
						c.abreviatura
						
					from empleados as e
					join companias_empleados as ce
						on ce.id_empleado=e.id_empleado
					join companias as c
						on c.id_compania = ce.id_compania
					where e.id_empleado=$empleado" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$compania = '';
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_array($resultado);
				$compania = $row[0];
			}
			return $compania ;
			//return $sql;
		}

		function loadByAspirante($empleado){
			$sql = "select * from $this->tabla where id_empleado=$empleado and estatus='ASPIRANTE'" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)){
				while ($row = mysql_fetch_assoc($resultado)) {
					$this->id=$row['id_empleado'];
					$this->nombre = $row['nombre'];
					$this->apellido_paterno=$row['apellido_paterno'];
					$this->apellido_materno=$row['apellido_materno'];
					$this->fecha_nacimiento=$row['fecha_nacimiento'];
					$this->curp=$row['curp'];
					$this->ife=$row['ife'];
					$this->matricula_smn=$row['matricula_smn'];
					$this->tipo_sangre=$row['tipo_sangre'];
					$this->licencia=$row['licencia'];
					$this->telefono_fijo=$row['telefono_fijo'];
					$this->telefono_movil=$row['telefono_movil'];
					$this->email=$row['email'];
					$this->fecha_inicio=$row['fecha_inicio'];
					$this->sexo=$row['sexo'];
					$this->observaciones=$row['observaciones'];
					$this->curriculum=$row['curriculum'];
					$this->foto=$row['foto'];
					$this->numero_imss=$row['numero_imss'];
					$this->estatus=$row['estatus'];
					$this->fecha_fin=$row['fecha_fin'];
					$this->detalle_direccion=$row['id_detalle_direccion'];
					$this->clinica=$row['id_clinica'];
					$this->cuenta_bancaria=$row['id_cuenta_bancaria'];
				}
				return true;
			}
			else{
				return false ;
			}
		}

		function loadById($empleado){
			$sql = "select * from $this->tabla where id_empleado=$empleado and (estatus='LABORANDO' OR estatus='ASPIRANTE')  " ;
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)){
				while ($row = mysql_fetch_assoc($resultado)) {
					$this->id=$row['id_empleado'];
					$this->nombre = $row['nombre'];
					$this->apellido_paterno=$row['apellido_paterno'];
					$this->apellido_materno=$row['apellido_materno'];
					$this->fecha_nacimiento=$row['fecha_nacimiento'];
					$this->curp=$row['curp'];
					$this->ife=$row['ife'];
					$this->matricula_smn=$row['matricula_smn'];
					$this->tipo_sangre=$row['tipo_sangre'];
					$this->licencia=$row['licencia'];
					$this->telefono_fijo=$row['telefono_fijo'];
					$this->telefono_movil=$row['telefono_movil'];
					$this->email=$row['email'];
					$this->fecha_inicio=$row['fecha_inicio'];
					$this->sexo=$row['sexo'];
					$this->observaciones=$row['observaciones'];
					$this->curriculum=$row['curriculum'];
					$this->foto=$row['foto'];
					$this->numero_imss=$row['numero_imss'];
					$this->estatus=$row['estatus'];
					$this->fecha_fin=$row['fecha_fin'];
					$this->detalle_direccion=$row['id_detalle_direccion'];
					$this->clinica=$row['id_clinica'];
					$this->cuenta_bancaria=$row['id_cuenta_bancaria'];
				}
				return $sql;
			}
			else{
				return false ;
			}
		}

		function loadByEstatus($estatus){
			$sql = "select * from $this->tabla where estatus='".$estatus."'" ;
			$activos = array();
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)){
				while ($row = mysql_fetch_assoc($resultado)) {
					$activos[] = $row ;
				}
				
			}
			return $activos ;
		}

		function getNombreCompleto($empleado){
			$sql = "select concat(apellido_paterno, ' ', apellido_materno , ' ', nombre) as namefull from $this->tabla where id_empleado=$empleado order by apellido_paterno asc" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)){
				$row = mysql_fetch_array($resultado);
				$nombre_completo = $row[0];
				return $nombre_completo ;
			}
			else{
				return null ;
			}
		}


		function getComparative($empleado){
			$sql = "select * from $this->tabla where replace( concat(nombre, apellido_paterno, apellido_materno),' ','' ) = '".$empleado."'" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado) > 0){
				return true ;
			}
			else{
				return false ;
			}
		}


		function getComparativeByCurp($curp){
			$sql = "select curp from $this->tabla where curp='$curp'";
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado) > 0){
				return true ;
			}
			else{
				return false ;
			}
		}


		function loadAll(){
			
		}

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getApellidoPaterno(){
			return $this->apellido_paterno ;
		}

		function getApellidoMaterno(){
			return $this->apellido_materno ;
		}

		function getFechaNacimiento(){
			return $this->fecha_nacimiento ;
		}

		function getCurp(){
			return $this->curp ;
		}

		function getIfe(){
			return $this->ife ;
		}

		function getMatriculaSmn(){
			return $this->matricula_smn ;
		}

		function getTipoSangre(){
			return $this->tipo_sangre ;
		}

		function getLicencia(){
			return $this->licencia ;
		}

		function getTelefonoFijo(){
			return $this->telefono_fijo ;
		}

		function getTelefonoMovil(){
			return $this->telefono_movil ;
		}

		function getEmail(){
			return $this->email ;
		}

		function getFechaInicio(){
			return $this->fecha_inicio ;
		}

		function getObservaciones(){
			return $this->observaciones ;
		}

		function getCurriculum(){
			return $this->curriculum ;
		}

		function getFoto(){
			return $this->foto ;
		}

		function getNumeroImss(){
			return $this->numero_imss ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getFechaFin(){
			return $this->fecha_fin ;
		}

		function getDetalleDireccion(){
			return $this->detalle_direccion ;
		}

		function getClinica(){
			return $this->clinica ;
		}

		function getCuentaBancaria(){
			return $this->cuenta_bancaria ;
		}

		function getSexo(){
			return $this->sexo ;
		}



	}

?>