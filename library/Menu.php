<?php

	class Menu{

		private $menu ;

		function printMenuEmpleados(){

			$this->menu=	"<div id=\"title-menu\">Empleados</div>
				<div id=\"menu\">
					<ul class=\"list-menu\">
						<li><span><a href=\"index.php\">Ver todos</a></span></li>
						<li><span><a href=\"empleado.php\">Nuevo empleado</a></span></li>
						<li><span><a href=\"empleado.php\">Editar empleado</a></span></li>
						<li><span><a href=\"nuevo_aspirante.php\">Nuevo aspirante</a></span></li>  
						<!-- <li><span><a href=\"empleado_aspirante.php\">Alta empleado</a></span></li> --> 
						<li><span><a href=\"asistencia_semanal.php\">Asistencia Semanal</a></span></li>
					</ul>
				</div>";
				return $this->menu;

		}

		function printMenuNominas(){

			$this->menu=	"<div id=\"title-menu\">Nóminas</div>
				<div id=\"menu\">
					<ul class=\"list-menu\">
						<li><span><a href=\"nomina_semanal_frente.php\">Resumen de nómina semanal</a></span></li>
					<!--	<li><span><a href=\"index.php\">Nómina Quincenal</a></span></li>
						<li><span><a href=\"#\">Nóminas anteriores</a></span></li>
						<li><span><a href=\"#\">Personal</a></span></li>  -->
					</ul>
				</div>";
				return $this->menu;

		}



		function printMenuAdministracion(){

			$this->menu=	"<div id=\"title-menu\">Administración</div>
				<div id=\"menu\">
					<ul class=\"list-menu\">
						<li><span><a href=\"index_frentes.php\">Frentes de Trabajo</a></span></li>
				<!--		<li><span><a href=\"#\">Afectaciones</a></span></li>
						<li><span><a href=\"#\">Ajustes semanales</a></span></li>
						<li><span><a href=\"#\">Usuarios</a></span></li>    -->
					</ul>
				</div>";
				return $this->menu;

		}

				function printMenuEstadisticas(){

			$this->menu=	"<div id=\"title-menu\">Estadísiticas</div>
				<div id=\"menu\">
					<ul class=\"list-menu\">
						<li><span><a href=\"index.php\">Nóminas semanales</a></span></li>
				<!--		<li><span><a href=\"#\">Afectaciones</a></span></li>
						<li><span><a href=\"#\">Ajustes semanales</a></span></li>
						<li><span><a href=\"#\">Usuarios</a></span></li>    -->
					</ul>
				</div>";
				return $this->menu;

		}




		function printMainManu(){
			$this->menu = "<div id=\"main_menu\">
					<ul>
						<li>
							<a href=\"../empleados/\"> 
									
								<span>Empleados</span>
							</a>
						</li>
						<li>
							<a href=\"../nominas/\" >
									
								<span>Nóminas</span>
							</a>
						</li>
						<li>
							<a href=\"../estadisticas/\" >
									
								<span>Estadísiticas</span>
							</a>
						</li>
						<li class=\"last\">
							<a href=\"../administracion\" >
									
								<span>Administracion</span>
							</a>
						</li>  
					</ul>
					
				</div>";
				return $this->menu;
		}

	}

?>