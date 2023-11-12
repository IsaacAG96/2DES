<?php

session_name("Adivinar_num");
session_start();
if (!isset($_SESSION["Numero"])) {
  $_SESSION["Numero"] = random_int(1, 20);
  echo ("Respuesta: " . $_SESSION["Numero"]);
  echo ("<br>");
}


if (!isset($_SESSION["Intentos"])) {
  $_SESSION["Intentos"] = 5;
} else if ($_SESSION["Intentos"] == 0) {
  echo ("La respuesta correcta era: " . $_SESSION["Numero"]);
  echo ("<br>");
  echo ("Has perdido");
  exit();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adivinar</title>
</head>
<!--
Realizar el programa  adivina.php que haciendo uso de variables de sesión implemente
 un juego donde el usuario tenga que adivinar un número entre 1 y 20 teniendo 5 oportunidades
  para acertar. El programa le informará si el valor es inferior o superior al generado.
  
Cada vez que se accede el programa decrementará el número de oportunidades, si estas son 
cero indicará que el usuario ha perdido y que no puede realizar más intentos.

El programa ofrecerá en todo momento la posibilidad de generar una nueva partida.
-->

<body>
  <?php if ($_SERVER['REQUEST_METHOD'] == "GET") : ?>
    <form action="adivina.php" method="POST">

      <?php
      echo ("Intentos: " . $_SESSION["Intentos"]);
      ?>
      <br>
      <input type="number" name="respuesta" placeholder="Numero del 1 al 20">
      <br>
      <input type="submit" value="Enviar">

    </form>
  <?php else : ?>
    <!-- PROCESO EL FORMULARIO -->
    <?= procesarFormulario(); ?>
  <?php endif ?>
</body>

</html>
<?php

function procesarFormulario()
{
  echo ("Respuesta: " . $_SESSION["Numero"]);
  echo ("<br>");

  $respuesta = $_POST["respuesta"];

  if ($respuesta > $_SESSION["Numero"]) {
    echo ("El numero que buscas es menor!");
    echo ("<br>");
    $_SESSION["Intentos"]--;
    echo ("Intentos restantes: " . $_SESSION["Intentos"]);
    header("Refresh:5; url=\"" . $_SERVER['PHP_SELF'] . "\"");
  } else if ($respuesta < $_SESSION["Numero"]) {
    echo ("El numero que buscas es mayor!");
    echo ("<br>");
    $_SESSION["Intentos"]--;
    echo ("Intentos restantes: " . $_SESSION["Intentos"]);
    header("Refresh:5; url=\"" . $_SERVER['PHP_SELF'] . "\"");
  } else if ($respuesta == $_SESSION["Numero"]) {
    echo ("Has acertado");
  }
}
?>