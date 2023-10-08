<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar numeros aleatorios,hallar maximo,minimo y moda</title>
</head>

<body>
    <?php

function llenar_lista()
{
    $lista=[];
    echo '<table class="default" border="1"><tr>';
    for ($contador = 0; $contador < 20; $contador++) {
        $lista[$contador] = random_int(1, 10);

    echo 
        '<td>'.$lista[$contador] .'</td>'
        ;
    }
    echo '</tr></table>';

    return $lista;
}
function hallar_maximo($lista)
{
    $maximo_local=-1;

    for ($contador = 0; $contador < 20; $contador++) {

        if ($lista[$contador] > $maximo_local) {
            $maximo_local = $lista[$contador];
        }
    }
    return $maximo_local;
}
function hallar_minimo($lista)
{
    $minimo_local=11;

    for ($contador = 0; $contador < 20; $contador++) {

        if ($lista[$contador] < $minimo_local) {
            $minimo_local = $lista[$contador];
        }
    }
    return $minimo_local;
}
function moda($lista/*, &$moda  NO FUNCIONA*/)
{
    $moda_local=array_count_values( $lista);


    /*
    for ($contador = 0; $contador < 20; $contador++) {    
                    
        $moda[$lista[$contador]]=$moda[$lista[$contador]]+1;        
    }


    */
    return $moda_local;
}


function mas_repeticiones($moda, &$max_repeticiones, &$numero_mas_repetido)
    {
        foreach ($moda as $numero => $repeticiones) {


            if ($repeticiones > $max_repeticiones) {
                $max_repeticiones = $repeticiones;
                $numero_mas_repetido = $numero;
            }
        }
        
    }

/*
    function acciones()
    {
        global $lista;
        global $maximo;
        global $minimo;
        global $moda;
        global $max_repeticiones;
        global $numero_mas_repetido;

        llenar_lista($lista);
        hallar_maximo($lista, $maximo);
        hallar_minimo($lista, $minimo);
        moda($lista, $moda);
        mas_repeticiones($moda, $max_repeticiones, $numero_mas_repetido);
    };
*/
    $lista = llenar_lista();
    $maximo = hallar_maximo($lista);
    $minimo = hallar_minimo($lista);
    $moda=moda($lista);/*[] = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0]; NO FUNCIONA*/
    $max_repeticiones = 0;
    $numero_mas_repetido;
    
    mas_repeticiones($moda, $max_repeticiones, $numero_mas_repetido);

   /* acciones(); INECESARIO*/

    echo 'El numero maximo es: ' . $maximo . "<br>";

    echo 'El numero minimo es: ' . $minimo . "<br>";

    echo 'El numero mas repetido es: ' . $numero_mas_repetido . " y se repite : " . $max_repeticiones . " veces<br>";

    ?>

    </body>

</html>