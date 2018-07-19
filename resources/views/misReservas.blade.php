<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Vuelos</title>
		<link rel="stylesheet" href="css/plantilla1.css">
		<script>
			function cargarTabla(){
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				
						document.getElementById("divTablaReservas").innerHTML = this.responseText;
				}};
				xhr.open("GET","cargarLista", true); 
				xhr.send();	
		}
		function getChecked(){
	   			var checkboxes = document.getElementsByClassName("check");
	    		var valores = [];

	    		for (var i = 0; i < checkboxes.length; i++) {
	        		if(checkboxes[i].checked){
	           			 valores.push(checkboxes[i].value);
	       			}       
	   		 }

	    	valores = valores.join("-");
	   		return valores;
		}
		function eliminarReserva(){
			var ids = getChecked();
			//alert(ids);
			var xhr = new XMLHttpRequest();	
			xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
					document.getElementById("divTablaReservas").innerHTML = this.responseText;	
				}};
			xhr.open("GET","eliminarReserva?ids="+ids, true); 
			xhr.send();	
		}
		function buscarTabla(){
				var fechaIda = document.getElementById("fechaIdaDesde").value;
				var fechaVuelta = document.getElementById("fechaIdaHasta").value;
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				
						document.getElementById("divTablaReservas").innerHTML = this.responseText;
				}};
				xhr.open("GET","buscarReservas?fechaIda="+fechaIda+"&fechaVuelta="+fechaVuelta, true); 
				xhr.send();	
		}
		function reservaOrdenar(campo){
			var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				
						document.getElementById("divTablaReservas").innerHTML = this.responseText;
				}};
				xhr.open("GET","reservaOrdenar?campo="+campo, true); 
				xhr.send();	

		}
		</script>
</head>
<body class="fondo" onLoad="cargarTabla()">
	{{ csrf_field() }}
	<table class="tablaBuscar">
		<tr>
			<td class="texto">Fecha de ida desde:</td>
			<td><input type="date" class="boton" id="fechaIdaDesde" onChange="buscarTabla()"></td>
			<td class="texto">hasta:</td>
			<td><input type="date" class="boton" id="fechaIdaHasta" onChange="buscarTabla()"></td>
		</tr>
	</table> 
	
	<br>
	
	<div id="divTablaReservas">

	</div>
	
	<hr>
	
	<center><input type="submit" class="boton" name="botonAnularReservas" value="Anular reservas" onClick="eliminarReserva()"></center>

</body>
</html>