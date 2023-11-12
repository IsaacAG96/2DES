<?php

session_name("fruteria");
session_start();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA FRUTERIA</title>
</head>

<body>
    <?php

    if (isset($_SESSION["salir"])) {
        require_once('despedida.php');
    } else if (!isset($_SESSION["cliente"])) {
        require_once('bienvenida.php');
    } else if (isset($_SESSION["cliente"])) {
        require_once('compra.php');
    }

    ?>
</body>

</html>

<?php
function mostrarCompra()
{
    echo ("<table border=1px>");

    foreach ($_SESSION["lista"] as $fruta => $cantidad) {

        echo ("<tr>");
        echo ("<td> $fruta </td>");
        echo ("<td> $cantidad </td>");
        echo ("</tr>");
    }
    echo ("</table>");
}

function eliminarSesion()
{
    session_destroy();
    header("Refresh:0; url=\"" . $_SERVER['PHP_SELF'] . "\"");
}

?>