<?php

session_name("Selector_Tarjeta");
session_start();

/* NO FUNCIONA PREGUNTAR
$_SESSION["Tiempo_permitido"] = 60; //60 segundos durara la sesion antes de cerrarse
$_SESSION["Tiempo_inicio"] = time();
*/

if (isset($_GET["Tarjeta"])) { //Si recibe valor del navegador crea nuevo valor de sesion
    $_SESSION["Tarjeta"] = "imagenes/" . $_GET["Tarjeta"] . ".gif";

    header("Refresh:0; url=\"" . $_SERVER['PHP_SELF'] . "\"");
    echo "<body></html>";
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Forma de pago</title>
</head>
<!--
    Usando pagosesion.php la selección de tarjeta se mantendrá 
    mientras no cerremos el navegador o mientras no pase un tiempo fijado al crear la sesión.
 -->

<body>
    <div style="text-align:center">

        <?php

        if (isset($_SESSION["Tarjeta"])) { //Si existe el valor de sesion muestra cual es
            echo "<img src='" . $_SESSION["Tarjeta"] . "' />";
        } else { //Avisa que no se ha seleccionado ninguna y no existe valor de sesion
            echo ("<h1>No tiene forma de pago asignada</h1>");
        }

        /*
        if ((time() - $_SESSION["Tiempo_inicio"] > $_SESSION["Tiempo_permitido"])) {

            session_destroy();
            echo ("<h1>Sesion finalizada</h1>");
        } else {
            header("Refresh:0; url=\"" . $_SERVER['PHP_SELF'] . "\"");
        }
        */

        ?>

        <h2>SELECCIONE UNA NUEVA TARJETA DE CREDITO </h2><br>
        <a href='pagosesion.php?Tarjeta=cashu'><img src='imagenes/cashu.gif' /></a>&ensp;
        <a href='pagosesion.php?Tarjeta=cirrus1'><img src='imagenes/cirrus1.gif' /></a>&ensp;
        <a href='pagosesion.php?Tarjeta=dinersclub'><img src='imagenes/dinersclub.gif' /></a>&ensp;
        <a href='pagosesion.php?Tarjeta=mastercard1'><img src='imagenes/mastercard1.gif' /></a>&ensp;
        <a href='pagosesion.php?Tarjeta=paypal'><img src='imagenes/paypal.gif' /></a>&ensp;
        <a href='pagosesion.php?Tarjeta=visa1'><img src='imagenes/visa1.gif' /></a>&ensp;
        <a href='pagosesion.php?Tarjeta=visa_electron'><img src='imagenes/visa_electron.gif' /></a>

    </div>
</body>

</html>