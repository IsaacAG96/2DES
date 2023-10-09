<?php

define('PIEDRA1',  "&#x1F91C;"); //0
define('PIEDRA2',  "&#x1F91B;"); //0
define('TIJERAS',  "&#x1F596;"); //1
define('PAPEL',    "&#x1F91A;"); //2

$jugador1 = random_int(0, 2);
$jugador2 = random_int(0, 2);

$soluciones = [[0, 2, 1], [1, 0, 2], [2, 1, 0]]; /* 0 es empate | 1 es gana J1 | 2 es gana J2 */



function lanzamiento1($jugador1)
{
    switch ($jugador1) {

        case 0:
            echo PIEDRA1;
            break;

        case 1:
            echo TIJERAS;
            break;

        case 2:
            echo PAPEL;
            break;
    }
}

function lanzamiento2($jugador2)
{

    switch ($jugador2) {

        case 0:
            echo PIEDRA2;
            break;

        case 1:
            echo TIJERAS;
            break;

        case 2:
            echo  PAPEL;
            break;
    }
}


function resultado($soluciones, $jugador1, $jugador2)
{


    if ($soluciones[$jugador1][$jugador2] == 1) {
        echo "Gana J1";
    } else if ($soluciones[$jugador1][$jugador2] == 2) {
        echo 'Gana J2';
    } else if ($soluciones[$jugador1][$jugador2] == 0) {
        echo 'EMPATE';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piedra papel tijera VS</title>
</head>
<style type="text/css">
    h1 {
        font-size: 45px;

    }

    td {
        font-size: 60px;
    }

    p {
        font-size: 30px;
    }
</style>



<body>

    <h1>¡Piedra,Papel o Tijera!</h1>

    <table border="0">

        <tr>
            <td>J1</td>
            <td>J2</td>

        </tr>
        <tr>
            <td><?= lanzamiento1($jugador1) ?></td>
            <td><?= lanzamiento2($jugador2) ?></td>
        </tr>
    </table>

    <p><u><?= resultado($soluciones, $jugador1, $jugador2) ?></u></p>


</body>

</html>
