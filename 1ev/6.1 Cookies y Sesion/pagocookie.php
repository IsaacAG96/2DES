<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Forma de pago</title>
</head>
<!--
    Usando pagocookie.php la selección de tarjeta se mantendrá mientras 
    el cookie no se elimine o caduque aunque rearranquemos el navegador.
-->

<body>
    <div style="text-align:center">
        <?php

        if (isset($_GET['Tarjeta'])) { //Si recibe valor del navegador crea nueva cookie

            $nuevaTarjeta = "imagenes/" . $_GET['Tarjeta'] . ".gif"; //Se guarda el nombre de la tarjeta con la ruta y extension correcta
            setcookie("Tarjeta", $nuevaTarjeta, time() + 60 * 60 * 24 * 30 * 12, "/");
            echo "<img src='" . $nuevaTarjeta . "' />";
        } else if (isset($_COOKIE["Tarjeta"])) { //Si no recibe valor y existe cookie la mostrara
            echo "<img src='" . $_COOKIE["Tarjeta"] . "' />";
        } else { //Avisa que no se ha seleccionado ninguna y no existe cookie
            echo ("<h1>No tiene forma de pago asignada</h1>");
        }

        ?>


        <h2>SELECCIONE UNA NUEVA TARJETA DE CREDITO </h2><br>
        <a href='pagocookie.php?Tarjeta=cashu'><img src='imagenes/cashu.gif' /></a>&ensp;
        <a href='pagocookie.php?Tarjeta=cirrus1'><img src='imagenes/cirrus1.gif' /></a>&ensp;
        <a href='pagocookie.php?Tarjeta=dinersclub'><img src='imagenes/dinersclub.gif' /></a>&ensp;
        <a href='pagocookie.php?Tarjeta=mastercard1'><img src='imagenes/mastercard1.gif' /></a>&ensp;
        <a href='pagocookie.php?Tarjeta=paypal'><img src='imagenes/paypal.gif' /></a>&ensp;
        <a href='pagocookie.php?Tarjeta=visa1'><img src='imagenes/visa1.gif' /></a>&ensp;
        <a href='pagocookie.php?Tarjeta=visa_electron'><img src='imagenes/visa_electron.gif' /></a>

    </div>
</body>

</html>