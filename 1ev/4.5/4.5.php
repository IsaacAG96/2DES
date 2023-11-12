<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="4.5.css" rel="stylesheet" type="text/css" />
    <title>Ejercicio 4.5</title>
</head>
<!--Elaborar un programa (05.php) que muestre y procese el siguiente
 formulario enviado por el método POST y genere los siguientes tipos  
 de respuestas en función de los datos recibidos:


    • Se indicará Bienvenida o Bienvenido en función del sexo.
    • Se añadirá Dña. o D. si tiene más de 55 años
    • La lista de hobbys se mostrará tratando los casos cuando no 
    se ha seleccionado ningún  hobby o cuando se ha seleccionado uno solo. 
    • Filtrar las entradas con datos que se van a mostrar para evitar los ataques 
    de inyección de código. 

-->

<body>
    <div id="container" style="width: 600px;">
        <div id="header">
            <h1>DATOS PERSONALES</h1>
        </div>

        <div id="content">
            <!-- MUESTRO EL FORMULARIO -->
            <?php if ($_SERVER['REQUEST_METHOD'] == "GET") : ?>
                <form method="post" name="datos" size=15>
                    Nombre: &nbsp; <input name="nombre"><br>
                    Apellidos: <input name="apellidos" size=30><br>
                    Edad: <select name="edad">
                        <option value='1'>Menor de 18</option>
                        <option value='2'>Entre 18 a 30</option>
                        <option value='3'>Entre 30 a 55</option>
                        <option value='4'>Mayor de 55</option>
                    </select>
                    <br> Sexo:
                    <input name="sexo" value="hombre" type=radio checked="checked">Hombre &nbsp;
                    <input name="sexo" value="mujer" type=radio>Mujer <br>
                    <br> Hobbies:<br>
                    <input name="hobbies[]" value="la lectura" type="checkbox"> lectura<br>
                    <input name="hobbies[]" value="ver la tele" type="checkbox">ver la tele<br>
                    <input name="hobbies[]" value="hacer deporte" type="checkbox">hacer deporte <br>
                    <input name="hobbies[]" value="salir de marcha" type="checkbox">Salir de marcha<br> <br>
                    <button>Enviar</button>
                </form>
            <?php else : ?>
                <!-- PROCESO EL FORMULARIO -->
                <?= procesarFormulario(); ?>
            <?php endif ?>

        </div>
    </div>
</body>

</html>

<?php
function procesarFormulario(): string
{

    //NOMBRE Y APELLIDO
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];



    $msg_hobbies = "";

    //SEXO
    $sexo = $_POST["sexo"];

    if ($sexo == "mujer") {
        $msg = "Bienvenida ";
    } else if ($sexo == "hombre") {
        $msg = "Bienvenido ";
    }

    //EDAD
    $edad = $_POST["edad"];

    if ($edad == 1 || $edad == 2 || $edad == 3) {
        $respeto = "";
    } else if ($edad == 4) {
        if ($sexo == "hombre") {
            $respeto = "Don ";
        } else if ($sexo == "mujer") {
            $respeto = "Doña ";
        }
    }

    //HOBBIES

    if (isset($_POST["hobbies"]) == false) {
        $msg_hobbies = " no tiene hobbies";
    } else if (isset($_POST["hobbies"]) == true) {

        $hobbies = $_POST["hobbies"];

        if (sizeOf($hobbies) == 1) {

            $msg_hobbies = " su unico hobbie es " . $hobbies[0];
        } else if (sizeOf($hobbies) > 1 && sizeOf($hobbies) <= 4) {

            $msg_hobbies = " sus hobbies son ";
            for ($contador = 0; $contador < sizeOf($hobbies); $contador++) {



                if ($contador == (sizeOf($hobbies) - 1)) {
                    $msg_hobbies = $msg_hobbies . " y " . $hobbies[$contador];
                } else {
                    $msg_hobbies = $msg_hobbies . " " . $hobbies[$contador] . ",";
                }
            }
        }
    }







    //MENSAJE FINAL

    $msg = $msg . $respeto . $nombre . " " . $apellidos . $msg_hobbies;
    return $msg;
}

?>