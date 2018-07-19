<select name="select" id="selectOrigen" onchange="cargarDestino(this.value);dibujarAsientos();">
	<?php 
		for ($i=0; $i <count($rutas); $i++) { 
			echo "<option value=\"".$rutas[$i]."\">".$rutas[$i]."</option>";	
		}
	?>
</select>