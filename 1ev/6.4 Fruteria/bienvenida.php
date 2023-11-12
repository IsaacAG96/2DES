<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>LA FRUTERIA</title>
</head>

<body>
    <H1> La Frutería del siglo XXI</H1>
    <B>BIENVENIDO A LA NUESTRA FRUTERÍA</B><br>

    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="GET">
        Introduzca su nombre del cliente:<input name="cliente" type="text"> <br>
    </form>
</body>

</html>

<?php
if (isset($_GET['cliente'])) {
    $_SESSION["cliente"] = $_GET["cliente"];
    header("Refresh:0; url=\"" . $_SERVER['PHP_SELF'] . "\"");
}

?>