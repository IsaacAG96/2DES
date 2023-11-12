<html>

<head>
  <meta charset="UTF-8">
  <title>LA FRUTERIA</title>
</head>

<body>
  <H1> La Frutería del siglo XXI</H1>
  <B><br> REALICE SU COMPRA <?= $_SESSION['cliente'] ?></B><br>
  <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
    <b>Selecciona la fruta: <select name="fruta">
        <option value="Platanos">Platanos</option>
        <option value="Naranjas">Naranjas</option>
        <option value="Limones">Limones</option>
        <option value="Manzanas">Manzanas</option>
      </select>
      Cantidad: <input name="cantidad" type="number" value=0 size=4>
      <input type="submit" name="accion" value="Anotar">
      <input type="submit" name="accion" value="Terminar">
  </form>
</body>

</html>


<?php


if (isset($_POST["accion"])) {
  $boton = $_POST["accion"];
} else if (!isset($_POST["accion"])) {
  $boton = "";
}


switch ($boton) {
  case "Anotar":
    if (isset($_SESSION["lista"][$_POST["fruta"]])) { //Si existe la clave acumulo

      $_SESSION["lista"][$_POST["fruta"]] += $_POST["cantidad"];
    } else if (!isset($_SESSION["lista"][$_POST["fruta"]])) { //Si no existe la creo
      $_SESSION["lista"][$_POST["fruta"]] = $_POST["cantidad"];
    }
    if ($_SESSION["lista"][$_POST["fruta"]] <= 0) { //Si sale negativo o igual a 0 lo elimino
      unset($_SESSION["lista"][$_POST["fruta"]]);
    }

    mostrarCompra(); //GENERO LA TABLA
    break;

  case "Terminar":
    $_SESSION["salir"] = true;
    echo ($_SESSION["salir"]);
    header("Refresh:0; url=\"" . $_SERVER['PHP_SELF'] . "\"");
    break;
}
?>