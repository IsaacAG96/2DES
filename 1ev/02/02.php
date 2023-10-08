<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de medios con hipervinculo</title>
</head>

<body>

    <?php
    $medios = ["El Pais" => "https://elpais.com/", "El Mundo" => "https://www.elmundo.es/", "Marca" => "https://www.marca.com/", "ABC" => "https://www.abc.es/", "EL ESPAÑOL" => "https://www.elespanol.com/"];

    echo "<ul>";
    foreach ($medios as $nombre => $enlace) {

        echo "<li><a href='$enlace'>$nombre</a></li>";
    }
    echo "</ul>";

    ?>

</body>

</html>