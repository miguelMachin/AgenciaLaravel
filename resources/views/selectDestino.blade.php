<select name="select" id="selectDestino" onchange="dibujarAsientos()">
	<?php 
		for ($i=0; $i <count($rutas); $i++) { 
			echo "<option value=\"".$rutas[$i]."\">".$rutas[$i]."</option>";	
		}
	?>
</select>