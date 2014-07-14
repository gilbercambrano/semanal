// Creación del objeto
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
// Función que recibe los parámetros enviados por grafico1.php, desde los enlaces de cada barra.
// Envía esos datos a grafico2.php para que los procese.
// Una vez procesados esos datos, se despliega en pantalla el gráfico detalle en el DIV "detalle_chart" haciendose ahora visible.
function detalleAnios(anio) {
	detalleDiv = document.getElementById('detalle_chart');
	detalleDiv.innerHTML = "";
	ajax = objetoAjax();
	ajax.open("POST", "graficos/grafico2.php");
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4) {
				detalleDiv.innerHTML = ajax.responseText
				detalleDiv.style.display="block";
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("anio="+anio )
}