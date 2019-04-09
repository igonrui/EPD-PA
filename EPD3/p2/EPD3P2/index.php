<?php

function provincias($a, $b) {
    return strcmp($a["PROVINCIA"], $b["PROVINCIA"]);
}
?>
<html>
    <?php
    $num = 5;
    $radio = array(
        array("PROVINCIA" => "Sevilla", "CIF" => "R7129438C", "DENOMINACION" => "CHO MEDIA, S.L.", "TIPO DE LICENCIA" => 1, "POBLACIÓN" => "Alcala de Guadaira"),
        array("PROVINCIA" => "Cadiz", "CIF" => "J5944515E", "DENOMINACION" => "NAFT MEDIA, S.L.", "TIPO DE LICENCIA" => 16, "POBLACIÓN" => "Algeciras"),
        array("PROVINCIA" => "Huelva", "CIF" => "W6300921A", "DENOMINACION" => "TELE CONDADO S.L.", "TIPO DE LICENCIA" => 37, "POBLACIÓN" => "Almonte"),
        array("PROVINCIA" => "Cadiz", "CIF" => "W6990539F", "DENOMINACION" => "REDCAPAC, S.L.", "TIPO DE LICENCIA" => 64, "POBLACIÓN" => "Rota"),
        array("PROVINCIA" => "Huelva", "CIF" => "D46397030", "DENOMINACION" => "RIBAMONTANA TV, S.L.", "TIPO DE LICENCIA" => 45, "POBLACIÓN" => "Aracena"),
        array("PROVINCIA" => "Murcia", "CIF" => "C59493841", "DENOMINACION" => "VIACOM INTERNATIONAL MEDIA NETWORKS ESPAÑA, S.L.U.", "TIPO DE LICENCIA" => 23, "POBLACIÓN" => "Lorca"),
        array("PROVINCIA" => "Sevilla", "CIF" => "R7129438C", "DENOMINACION" => "CANAL COSMOPOLITAN IBERIA, S.L.U.", "TIPO DE LICENCIA" => 25, "POBLACIÓN" => "Tomares"),
        array("PROVINCIA" => "Madrid", "CIF" => "B89435879", "DENOMINACION" => "SOCIEDAD GESTORA DE TELEVISION NET TV, S.A.", "TIPO DE LICENCIA" => 23, "POBLACIÓN" => "Madrid"),
        array("PROVINCIA" => "Barcelona", "CIF" => "W3440576A", "DENOMINACION" => "THE WALT DISNEY COMPANY IBERIA, S.L.", "TIPO DE LICENCIA" => 1, "POBLACIÓN" => "Barcelona"),
        array("PROVINCIA" => "Almería", "CIF" => "S6081811I", "DENOMINACION" => "NBC UNIVERSAL GLOBAL NETWORKS ESPAÑA SLU", "TIPO DE LICENCIA" => 12, "POBLACIÓN" => "Carboneras"),
        array("PROVINCIA" => "Granada", "CIF" => "F7409478J", "DENOMINACION" => "The History Channel Iberia S.L.", "TIPO DE LICENCIA" => 13, "POBLACIÓN" => "Alquife")
    );
    ?>

    <head>
        <meta charset = "UTF-8">
        <title></title>
    </head>
    <body>
        <h1 align="center">REGISTRO DE PRESTADORES DE LA COMUNICACIÓN AUDIOVISUAL</h1>
        <table border="1" align="center">
            <thead align="center">
                <?php
                
                //mostrar la parte superior de la tabla(CLAVES)
                echo "<tr>";
                $claves = array_keys($radio[0]);
                foreach ($claves as $keys) {
                    echo "<th>";
                    echo "$keys";
                    echo "</th>";
                }
                echo "</tr>";
                ?>
            </thead>
            <tbody align="center">
                <?php
                usort($radio, "provincias");

                foreach ($radio as $row) {
                    echo "<tr>";
                    foreach ($row as $provincias) {
                        echo "<td>";
                        echo $provincias . "</td>";
                    }
                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
    </body>
</html>