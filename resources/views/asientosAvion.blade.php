<table class="tablaAsientos">
    <?php 
        $contador = 1;
        for ($i=0; $i < 2 ; $i++) { 
            echo "<tr>";
                for ($j=0; $j < 4 ; $j++) { 
                    if (!in_array($contador,$asientos)){
                        echo "<td><input name =\"asiento\" type=\"radio\" value=\"".$contador."\">".$contador."</td>";
                    }else{
                        echo "<td></td>";
                    }
                    $contador++;
                }
            echo "</tr>";
            }
    ?>
</table>