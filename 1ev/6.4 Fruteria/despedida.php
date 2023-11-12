<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>LA FRUTERIA</title>
</head>

<body>
    <H1> La Frutería del siglo XXI</H1>
    <?php
    mostrarCompra();
    ?>
    <br> Muchas gracias, por su pedido. <br><br>

    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="submit" name="borrar" value=" BOOM "> <!--Se activa sin pulsar ??? -->
    </form>
    
    <!-- No hace nada ??? -->
    <!--  <input type="button" value=" NUEVO CLIENTE " onclick="location.href='<?= $_SERVER['PHP_SELF']; ?>'">  -->
</body>

</html>


<?php
if (isset($_POST["borrar"])) {
    eliminarSesion();
}
?>