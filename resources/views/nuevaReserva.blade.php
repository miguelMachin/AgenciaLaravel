<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Vuelos</title>
		<link rel="stylesheet" href="css/plantilla1.css">
		<script>
		function cargarTodo(){
			cargarOrigen();
		}

		function cargarOrigen(){
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
						document.getElementById("divOrigen").innerHTML = this.responseText;
						cargarDestino(document.getElementById("selectOrigen").value);
				}};
				xhr.open("GET","cargarOrigen?&origen=TODOS", true); 
				xhr.send();	
		}

		function cargarDestino(origen){
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("divDestino").innerHTML = this.responseText;
				}};
				xhr.open("GET","cargarDestino?&origen="+origen, true); 
				xhr.send();	
		}

		function dibujarAsientos(){
			var origen = document.getElementById("selectOrigen").value;
			var destino = document.getElementById("selectDestino").value;
			var fechaIda = document.getElementById("fechaIda").value;
			var fechaVuelta = document.getElementById("fechaVuelta").value;
			if (fechaIda > fechaVuelta){
				alert("La fecha de Ida no puede ser mayor que la de vuelta");
			}else{
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("divAsientosAvion").innerHTML = this.responseText;
					dibujarRuta(origen,destino);
				}};
				xhr.open("GET","dibujarAsientos?origen="+origen+"&destino="+destino+"&fechaIda="+fechaIda+"&fechaVuelta="+fechaVuelta, true); 
				xhr.send();
			}
		}

		function dibujarRuta(origen, destino){
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("divRuta").innerHTML = this.responseText;
			}};
			xhr.open("GET","dibujarRuta?origen="+origen+"&destino="+destino, true); 
			xhr.send();
		}
		
		function saberSelect(){
			console.log("SADSAD");
			var asientos = document.getElementsByName("asiento");
			console.log(asientos);
			for (let i = 0; i < asientos.length; i++) {
				if(asientos[i].checked  == true){
					return asientos[i].value;
				}
			}
		}

		function reservar(){
			var origen = document.getElementById("selectOrigen").value;
			var destino = document.getElementById("selectDestino").value;
			var fechaIda = document.getElementById("fechaIda").value;
			var fechaVuelta = document.getElementById("fechaVuelta").value;
			var asiento = saberSelect();

			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				alert(this.responseText);
			}};
			xhr.open("GET","reservar?origen="+origen+"&destino="+destino+"&fechaIda="+fechaIda+"&fechaVuelta="+fechaVuelta+"&asiento="+asiento, true); 
			xhr.send();
		}
			  
		</script>
</head>
<body class="fondo" onLoad="cargarTodo()">
	{{ csrf_field() }}
	
	<div id="divMensaje">
	
	</div>
	
	<table class="tablaNuevo">
		<tr>
			<td class="texto">Origen:</td>
			<td>
				<div id="divOrigen">
				
				</div>
			</td>
			<td class="texto">Destino:</td>
			<td>
				<div id="divDestino">
				
				</div>
			</td>
		</tr>
		<tr>
			<td class="texto">Fecha de ida:</td>
			<td><input type="date" class="boton" id="fechaIda" name="fechaIda" onChange="dibujarAsientos()" required></td>
			<td class="texto">Fecha de vuelta:</td>
			<td><input type="date" class="boton" id="fechaVuelta" name="fechaVuelta" onChange="dibujarAsientos()" required></td>
		</tr>		
	</table>
	<span class="texto">&nbsp;&nbsp;&nbsp;&nbsp;Asiento:</span>
		
	<div id="divAvion">
		<div id="divAlaSuperiorAvion"><img src="imagenes/alasuperior.png"></div>
		<div id="divCabezaAvion"><img src="imagenes/cabeza.png"></div>
		<div id="divAsientosAvion">
			
		</div>
		<div id="divColaAvion"><img src="imagenes/cola.png"></div>
		<div id="divAlaInferiorAvion"><img src="imagenes/alainferior.png"></div>
	</div>
	<br>
	<center><input type="submit" class="boton" name="botonNuevaReserva" value="Reservar" onClick="reservar()"></center>
	
	<div id="divRuta">

	</div>
	

</body>
</html>