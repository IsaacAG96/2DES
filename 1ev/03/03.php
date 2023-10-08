<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medio random con hipervinculo</title>
</head>

<body>

    <?php
    $medios = ["El Pais" => "https://elpais.com/", "El Mundo" => "https://www.elmundo.es/", "Marca" => "https://www.marca.com/", "ABC" => "https://www.abc.es/", "EL ESPAÑOL" => "https://www.elespanol.com/"];

    $numero_random=random_int(1, 5);
    $contador=1;
    foreach ($medios as $nombre => $enlace) {

        if($contador==$numero_random){

        echo "<li>El medio recomendado es: <a href='$enlace'>$nombre</a></li>";
    break;}
        $contador++;
    }


    ?>
    
</body>

</html>