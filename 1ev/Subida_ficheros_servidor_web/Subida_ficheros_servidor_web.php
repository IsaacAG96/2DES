<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>subida ficheros servidor web</title>
</head>

<body>
    <?php
    // se incluyen esta tabla de  códigos de error que produce la subida de archivos en PHP
    // Posibles errores de subida segun el manual de PHP
    $directorio = 'C:\XAMPP\imgusers';
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

    // No se recibe nada, error al enviar el POST, se supera post_max_size
    if (count($_REQUEST) == 0) {
        $mensaje = "  Error: se supera el tamaño máximo de un petición POST ";
    }
    // si no se reciben el directorio de alojamiento y el archivo, se descarta el proceso
    else if ((!isset($_FILES['archivo1']['name'])) or  (!isset($_REQUEST[$directorio]))) { //(!isset($_REQUEST['directorio']))) {
        $mensaje .= 'ERROR: No se indicó el archivo y/o no se indicó el directorio';
    } else {

        foreach ($_FILES['archivos']['name'] as $i => $nombreFichero) {


            // se reciben el directorio de alojamiento y el archivo
            $directorioSubida = $_REQUEST[$directorio]; //$_REQUEST['directorio']; // debe permitir la escritua para Apache 
            // Información sobre el archivo subido
            $nombreFichero   =   $_FILES['archivo1']['name'][$i];
            $tipoFichero     =   $_FILES['archivo1']['type'][$i];
            $tamanioFichero  =   $_FILES['archivo1']['size'][$i];
            $temporalFichero =   $_FILES['archivo1']['tmp_name'][$i];
            $errorFichero    =   $_FILES['archivo1']['error'][$i];

            $mensaje .= 'Intentando subir el archivo: ' . ' <br />';
            $mensaje .= "- Nombre: $nombreFichero" . ' <br />';
            $mensaje .= '- Tamaño: ' . number_format(($tamanioFichero / 1000), 1, ',', '.') . ' KB <br />';
            $mensaje .= "- Tipo: $tipoFichero" . ' <br />';
            $mensaje .= "- Nombre archivo temporal: $temporalFichero" . ' <br />';
            $mensaje .= "- Código de estado: $errorFichero" . ' <br />';

            $mensaje .= '<br />RESULTADO<br />';

            // Obtengo el código de error de la operación, 0 si todo ha ido bien
            if ($errorFichero > 0) {
                $mensaje .= "Se ha producido el error nº $errorFichero: <em>"
                    . $codigosErrorSubida[$errorFichero] . '</em> <br />';
            } else { // subida correcta del temporal
                // si es un directorio y tengo permisos     
                if (is_dir($directorioSubida) && is_writable($directorioSubida)) {
                    //Intento mover el archivo temporal al directorio indicado
                    if (move_uploaded_file($temporalFichero,  $directorioSubida . '/' . $nombreFichero) == true) {
                        $mensaje .= 'Archivo guardado en: ' . $directorioSubida . '/' . $nombreFichero . ' <br />';
                    } else {
                        $mensaje .= 'ERROR: Archivo no guardado correctamente <br />';
                    }
                } else {
                    $mensaje .= 'ERROR: No es un directorio correcto o no se tiene permiso de escritura <br />';
                }
            }
        }
    }
    ?>

    <body>
        <?= (isset($_REQUEST['nombre'])) ? " Bienvenido " . $_REQUEST['nombre'] : "" ?><br>
        <?= $mensaje; ?>
        <br />
        <a href="Subida_ficheros_servidor_web.html">Volver a la página de subida</a>
    </body>

</html>