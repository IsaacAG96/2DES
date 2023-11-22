<html>

<head>
    <title>Procesa una subida de archivos </title>
    <meta charset="UTF-8">
</head>
<?php
// se incluyen esta tabla de  códigos de error que produce la subida de archivos en PHPP
// Posibles errores de subida segun el manual de PHP
$codigosErrorSubida = [
    UPLOAD_ERR_OK         => 'Subida correcta',  // Valor 0
    UPLOAD_ERR_INI_SIZE   => 'El tamaño del archivo excede el admitido por el servidor',  // directiva upload_max_filesize en php.ini
    UPLOAD_ERR_FORM_SIZE  => 'El tamaño del archivo excede el admitido por el cliente',  // directiva MAX_FILE_SIZE en el formulario HTML
    UPLOAD_ERR_PARTIAL    => 'El archivo no se pudo subir completamente',
    UPLOAD_ERR_NO_FILE    => 'No se seleccionó ningún archivo para ser subido',
    UPLOAD_ERR_NO_TMP_DIR => 'No existe un directorio temporal donde subir el archivo',
    UPLOAD_ERR_CANT_WRITE => 'No se pudo guardar el archivo en disco',  // permisos
    UPLOAD_ERR_EXTENSION  => 'Una extensión PHP evito la subida del archivo',  // extensión PHP

];
$mensaje = '';
$directorio = "imgusers"; // debe permitir la escritua para Apache

$total_maximo = 0; //acumulador tamaño de los ficheros

if (!file_exists($directorio)) {

    mkdir($directorio);
    chmod($directorio, 0777);
}


// No se recibe nada, error al enviar el POST, se supera post_max_size
if (count($_POST) == 0) {
    $mensaje .= "  Error: se supera el tamaño máximo de un petición POST ";
}
// si no se reciben el directorio de alojamiento y el archivo, se descarta el proceso
else if ((!isset($_FILES['archivos']['name'])) || (!file_exists($directorio))) {
    $mensaje .= 'ERROR: No se indicó el archivo y/o no se indicó el directorio';
} else { // se reciben el directorio de alojamiento y el archivo

    $test1 = count($_FILES["archivos"]);
    for ($contador = 0; $contador < count($_FILES["archivos"]["name"]); $contador++) {
        // for ($contador = 0; $contador < count($_POST); $contador++) {


        // Información sobre el archivo subido
        $nombreFichero   =   $_FILES['archivos']['name'][$contador];
        $tipoFichero     =   $_FILES['archivos']['type'][$contador];
        $tamanioFichero  =   $_FILES['archivos']['size'][$contador];
        $temporalFichero =   $_FILES['archivos']['tmp_name'][$contador];
        $errorFichero    =   $_FILES['archivos']['error'][$contador];

        $total_maximo = $total_maximo + $tamanioFichero;


        if ($tamanioFichero > 200000) { //tamaño maximo por fichero
            $mensaje .= 'RESULTADO: <br> Superado el tamaño maximo por archivo' .
                '<br><a href="Subida_ficheros_servidor_web.html">Volver a la página de subida</a>';

            exit($mensaje);
        }
        if ($tamanioFichero > 300000) { //tamaño maximo de la suma total de todos los archivos subidos
            $mensaje = "RESULTADO: <br> Superado el tamaño maximo entre todos los archivos" .
                '<br><a href="Subida_ficheros_servidor_web.html">Volver a la página de subida</a>';
            exit($mensaje);
        }
        if (($tipoFichero != "image/jpeg")  && ($tipoFichero != "image/png")) {
            $mensaje .= "RESULTADO: <br> Tipo de fichero no valido,debe ser JPG o PNG" .
                '<br><a href="Subida_ficheros_servidor_web.html">Volver a la página de subida</a>';
            exit($mensaje);
        }

        $mensaje .= 'Intentando subir el archivo: ' . ' <br /><br>';
        $mensaje .= "- Nombre: $nombreFichero" . ' <br />';
        $mensaje .= '- Tamaño: ' . number_format(($tamanioFichero / 1000), 1, ',', '.') . ' KB <br />';
        $mensaje .= "- Tipo: $tipoFichero" . ' <br />';
        $mensaje .= "- Nombre archivo temporal: $temporalFichero" . ' <br />';
        $mensaje .= "- Código de estado: $errorFichero" . ' <br />';

        $mensaje .= '<br />RESULTADO: <br />';


        // Obtengo el código de error de la operación, 0 si todo ha ido bien
        if ($errorFichero > 0) {
            $mensaje .= "Se ha producido el error nº $errorFichero: <em>"
                . $codigosErrorSubida[$errorFichero] . '</em> <br />';
            $mensaje .= "<br><br>-----------------------------------------<br><br>";
        } else { // subida correcta del temporal

            if (is_dir($directorio) && is_writable($directorio)) { // si es un directorio y tengo permisos    

                // if (!file_exists($nombreFichero)) {
                if (!file_exists($directorio . '/' . $nombreFichero)) {

                    //Intento mover el archivo temporal al directorio indicado
                    if (move_uploaded_file($temporalFichero,  $directorio . '/' . $nombreFichero) == true) {
                        $mensaje .= 'Archivo guardado en: ' . $directorio . '/' . $nombreFichero . ' <br />';
                        $mensaje .= "<br><br>-----------------------------------------<br><br>";
                    } else {
                        $mensaje .= 'ERROR: Archivo no guardado correctamente <br />';
                        $mensaje .= "<br><br>-----------------------------------------<br><br>";
                    }
                } else if (file_exists($directorio . '/' . $nombreFichero)) {
                    $mensaje .= "El fichero ya existe";
                    $mensaje .= "<br><br>-----------------------------------------<br><br>";
                }
            } else {
                $mensaje .= 'ERROR: No es un directorio correcto o no se tiene permiso de escritura <br />';
                $mensaje .= "<br><br>-----------------------------------------<br><br>";
            }
        }
    }
}

?>

<body>
    <?= $mensaje; ?>
    <br>
    <a href="Subida_ficheros_servidor_web.html">Volver a la página de subida</a>
</body>

</html>