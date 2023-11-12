<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4.1</title>
</head>
<!--Elaborar programa (01.php) en php que procese un formulario (01.html) 
que solicita al usuario un nombre y una clave. El programa php tendrá un array 
asociativo con 3 pares de valores de usuario => contraseña .  Se comprobará consultando
 la tabla si los datos son válidos, en este caso se debe mostrar un mensaje de bienvenida
  con nombre introducido , en otro caso se mostrar un mensaje de error para que usuario pueda 
  volver a introducir nuevos datos.-->

<body>


    <?php
    $datos = [
        "pepe" => "123",
        "juan" => "456",
        "luis" => "789"
    ];

    echo (procesarFormulario($datos));


    function procesarFormulario($datos): string
    {

        //NOMBRE Y APELLIDO
        $nombre = $_POST["nombre"];
        $clave = $_POST["clave"];


        for ($contador = 0; $contador < sizeOf($datos); $contador++) {
        }
        foreach ($datos as $nombre_array => $clave_array) {
            if (($nombre_array == $nombre) && ($clave_array == $clave)) {
                return "Bienvenido " . $nombre;
            } else if (($nombre_array != $nombre) && ($clave_array != $clave)) {
                return "Error al introducir los datos";
            }
        }
    }

    ?>

</body>

</html>