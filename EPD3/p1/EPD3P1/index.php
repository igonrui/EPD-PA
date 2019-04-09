<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset = "UTF-8">
        <title></title>
    </head>
    <body>
        <h1 align="center">MARTES 13 DE LOS PRÓXIMOS 100 AÑOS</h1>
        <table border="1" align="center">
            <thead align="center">
                <tr>
                    <th>MES</th>
                    <th>ANO</th>
                </tr>
            </thead>
            <tbody align="center">
                <?php
                $s1 = array(0 => "Domingo", 1 => "Lunes", 2 => "Martes",
                    3 => "Miercoles", 4 => "Jueves", 5 => "Viernes", 6 => "Sabado");
                $m = array(11 => "Enero", 12 => "Febrero", 1 => "Marzo",
                    2 => "Abril", 3 => "Mayo", 4 => "Junio", 5 => "Julio",
                    6 => "Agosto", 7 => "Septiembre", 8 => "Octubre", 9 => "Noviembre",
                    10 => "Diciembre");
                $siglo2 = array(0 => 0, 1 => 6, 2 => 4, 3 => 2);


                $semana = (int) 2;
                $dia = (int) 13;
                //$ano = (int) 18;
                //$mes = (int) 8;
                $siglo = (int) 20;

                $martes13 = array();
                for ($ano = 18; $ano < 99; $ano++) {
                    for ($mes = 1; $mes < 13; $mes++) {
                        $op1 = (int)(0.2 * (13 * $mes - 1));
                        $op2 = (int)(0.25 * $ano);
                        $op3 = (int)(0.25 * $siglo);
                        if ((($dia + $op1 + $ano + $op2 + $op3 - 2 * $siglo)) % 7 == $semana) {
                            $martes13[] = array("MES"=> $m[$mes], "ANO"=> $ano);
                        }
                    }
                }
                foreach ($martes13 as $row) {
                    echo "<tr>";
                    foreach ($row as $martes) {
                        echo "<td>";
                        echo $martes . "</td>";
                    }
                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
    </body>
</html>
