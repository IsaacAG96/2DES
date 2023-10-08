<?php

$dados = ['&#9856;', '&#9857', '&#9858;', '&#9859;', '&#9860;', '&#9861;'];

for ($contador = 0; $contador < 6; $contador++) {  //lanzamientos j1

    $lanzamiento = random_int(56, 61);
    $lista_j1[$contador] = $lanzamiento;
}

function resultado_j1($lista_j1)
{

    sort($lista_j1); //ordenar

    $recuento_j1 = 0;

    for ($contador = 0; $contador < 6; $contador++) {
        $recuento_j1 = $recuento_j1 + $lista_j1[$contador] - 55;
    }
    $recuento_j1 = $recuento_j1 -  $lista_j1[0] - $lista_j1[5] + 110; //se suma 110 para corregir que se resto dos veces 55 en el bucle anterior
    return $recuento_j1;
}
$recuento_j1 = resultado_j1($lista_j1);


for ($contador = 0; $contador < 6; $contador++) { //lanzamientos j2

    $lanzamiento = random_int(56, 61);
    $lista_j2[$contador] = $lanzamiento;
}

///////////////////////////////////////////////////////////////////////////////////////////////////

function resultado_j2($lista_j2)
{
    sort($lista_j2); //ordenar

    $recuento_j2 = 0;

    for ($contador = 0; $contador < 6; $contador++) {
        $recuento_j2 = $recuento_j2 + $lista_j2[$contador] - 55;
    }
    $recuento_j2 = $recuento_j2 - $lista_j2[0] - $lista_j2[5] + 110;  //se suma 110 para corregir que se resto dos veces 55 en el bucle anterior
    return $recuento_j2;
}
$recuento_j2 = resultado_j2($lista_j2);

///////////////////////////////////////////////////////////////////////////////////////////////////

function comparar($recuento_j1, $recuento_j2)
{

    if ($recuento_j1 > $recuento_j2) {
        return 'J1';
    } else if ($recuento_j1 < $recuento_j2) {
        return 'J2';
    } else if ($recuento_j1 == $recuento_j2) {
        return 'EMPATE';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dado</title>
</head>

<style type="text/css">
    td {
        font-size: 20px;
    }
</style>

<body>

    <table border="0">

        <tr>
            <td>Jugador 1 -></td>
            <td>Dado1 : &#98<?= $lista_j1[0]; ?>; | </td>
            <td>Dado2 : &#98<?= $lista_j1[1]; ?>; | </td>
            <td>Dado3 : &#98<?= $lista_j1[2]; ?>; | </td>
            <td>Dado4 : &#98<?= $lista_j1[3]; ?>; | </td>
            <td>Dado5 : &#98<?= $lista_j1[4]; ?>; | </td>
            <td>Dado6 : &#98<?= $lista_j1[5]; ?>; | </td>
            <td><?= resultado_j1($lista_j1) ?> puntos</td>

        </tr>

        <tr>
            <td>Jugador 2 -></td>
            <td>Dado1 : &#98<?= $lista_j2[0]; ?>; | </td>
            <td>Dado2 : &#98<?= $lista_j2[1]; ?>; | </td>
            <td>Dado3 : &#98<?= $lista_j2[2]; ?>; | </td>
            <td>Dado4 : &#98<?= $lista_j2[3]; ?>; | </td>
            <td>Dado5 : &#98<?= $lista_j2[4]; ?>; | </td>
            <td>Dado6 : &#98<?= $lista_j2[5]; ?>; | </td>
            <td><?= resultado_j2($lista_j2) ?> puntos</td>

        </tr>

    </table>

    <h1>Resultado: Ganador es <u><?= comparar($recuento_j1, $recuento_j2) ?></u></h1>

</body>

</html>