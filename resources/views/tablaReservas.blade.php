<table>
	<tr><th></th><th onClick="reservaOrdenar('origen')">Origen</th><th>Destino</th><th onClick="reservaOrdenar('fechaIda')">Fecha ida</th><th>Fecha Vuelva</th><th>Asiento</th></tr>
	<?php 
		for ($i=0; $i < count($registros) ; $i++) { 
			echo "<tr>";
			echo "<td><input type=\"checkbox\" class=\"check\" value=\"".$registros[$i]->idReserva."\"/></td>";
			echo "<td>".$registros[$i]->origen."</td>";
			echo "<td>".$registros[$i]->destino."</td>";
			echo "<td>".$registros[$i]->fechaIda."</td>";
			echo "<td>".$registros[$i]->fechaVuelta."</td>";
			echo "<td>".$registros[$i]->asiento."</td>";
			echo "</tr>";
		}
	?>

</table>