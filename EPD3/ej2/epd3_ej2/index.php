<!DOCTYPE html>
<html>
    <head>
        <meta charset=UTF-8>
    <body>
        <?php
        calculoFecha(3, 2, 2016, 26);

        function calculoFecha($dia, $mes, $anyo, $sumaDias)
        {
            echo "<br /><br />La fecha introducida es: $dia / $mes / $anyo <br /><br /><br />";


            //si el mes es enero marzo mayo  julio agosto octubre o diciembre
            if ($mes == 1 || $mes == 3 || $mes == 5 || $mes == 7 || $mes == 8 || $mes == 10 || $mes == 12)
            {
                if ($dia + $sumaDias > 31)
                {
                    $mes = $mes + 1;
                    $dia = $sumaDias - (31 - $dia);
                }
                else
                {
                    $dia = $dia  + $sumaDias;
                }
            }


            //Si el mes es Abril Junio Septiembre o Noviembre
            else if ($mes == 4 || $mes == 6 || $mes == 9 || $mes == 11)
            {
                if ($dia + $sumaDias > 30)
                {
                    $mes = $mes + 1;
                    $dia = $sumaDias - (30 - $dia);
                }
                else
                    $dia = $dia  + $sumaDias;
            }


            //Si el mes es Febrero    
            else if ($mes == 2)
            {
                if ($anyo % 4 == 0)
                {
                    if ($dia + $sumaDias > 29)
                    {
                        $mes = $mes + 1;
                        $dia = $sumaDias - (29 - $dia);
                    }
                    else
                    {
                        $dia = $dia + $sumaDias;
                    }
                }
                else
                {
                    if ($dia + $sumaDias > 28)
                    {
                        $mes = $mes + 1;
                        $dia = $sumaDias - (28 - $dia);
                    }
                    else
                    {
                        $dia = $dia  + $sumaDias;
                    }
                }
            }


            //si no es un mes valido
            else
            {
                echo "la fecha introducida no es valida";
            }

            //Devolvemos la fecha modificada
            echo "La fecha resultante de la suma de $sumaDias dias es: $dia / $mes / $anyo ";
        }
        ?>
    </body>
</html>