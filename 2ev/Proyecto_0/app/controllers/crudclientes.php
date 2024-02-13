<?php

function crudBorrar($id)
{
    $db = AccesoDatos::getModelo();
    $resu = $db->borrarCliente($id);
    if ($resu) {
        // Construir la ruta de la imagen basada en el ID del cliente
        $rutaImagenJPG = sprintf("./app/uploads/%08d.jpg", $id);
        $rutaImagenPNG = sprintf("./app/uploads/%08d.png", $id);

        // Verificar si existe un archivo con cualquiera de las extensiones
        if (file_exists($rutaImagenJPG)) {
            // Si existe, eliminar la imagen
            unlink($rutaImagenJPG);
        } elseif (file_exists($rutaImagenPNG)) {
            // Si existe, eliminar la imagen
            unlink($rutaImagenPNG);
        }

        $_SESSION['msg'] = "El usuario " . $id . " ha sido eliminado.";
    } else {
        $_SESSION['msg'] = "Error al eliminar el usuario " . $id . ".";
    }
}

function crudTerminar()
{
    AccesoDatos::closeModelo();
    session_destroy();
}

function crudAlta()
{
    $cli = new Cliente();
    $orden = "Nuevo";
    include_once "app/views/formulario.php";
}

function crudDetalles($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $bandera = obtenerBandera($cli);
    $imagen = mostrarImagenCliente($id);
    include_once "app/views/detalles.php";
}

function crudDetallesSiguiente($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    $bandera = obtenerBandera($cli);
    $imagen = mostrarImagenCliente($cli->id);
    include_once "app/views/detalles.php";
}

function crudDetallesAnterior($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    $bandera = obtenerBandera($cli);
    $imagen = mostrarImagenCliente($cli->id);
    include_once "app/views/detalles.php";
}


function crudModificar($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $orden = "Modificar";
    include_once "app/views/formulario.php";
}

function crudPostAlta()
{
    limpiarArrayEntrada($_POST); //Evitar la posible inyección de código

    // Validar que los datos sean correctos
    $errores = [];

    // Verificar que el correo electrónico no esté repetido
    $db = AccesoDatos::getModelo();

    //Verificar correo
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "-La estructura del correo no es válida.<br>";
    }

    //Comprobar que no se repita
    if ($db->existeEmail($_POST['id'], $_POST['email'])) {
        $errores[] = "-El correo electrónico ya está registrado.<br>";
    }

    // Verificar formato de la IP
    if (!filter_var($_POST['ip_address'], FILTER_VALIDATE_IP)) {
        $errores[] = "-El formato de la dirección IP no es válido.<br>";
    }

    // Verificar formato de teléfono (XXX-XXX-XXXX)
    if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $_POST['telefono'])) {
        $errores[] = "-El formato del teléfono no es válido. Debe ser XXX-XXX-XXXX.";
    }

    // Verificar si se ha subido una imagen
    if (!empty($_FILES['foto']['name'])) {
        $allowed_types = array('jpg', 'JPG', 'png', 'PNG');
        $temp = explode('.', $_FILES['foto']['name']);
        $extension = strtolower(end($temp)); // Convertir la extensión a minúsculas para evitar problemas con la comparación

        if (!in_array($extension, $allowed_types)) {
            $errores[] = "-La foto debe ser una imagen JPG o PNG.";
        }
    }

    // Si hay errores, mostrar mensaje y detener el proceso
    if (!empty($errores)) {
        $_SESSION['msg'] = "Error al dar de alta al usuario:<br> " . implode(" ", $errores);
        return;
    }

    // Si los datos son correctos, continuar con el proceso de alta del cliente
    $cli = new Cliente();
    $cli->id            = $_POST['id'];
    $cli->first_name    = $_POST['first_name'];
    $cli->last_name     = $_POST['last_name'];
    $cli->email         = $_POST['email'];
    $cli->gender        = $_POST['gender'];
    $cli->ip_address    = $_POST['ip_address'];
    $cli->telefono      = $_POST['telefono'];

    // Guardar la foto si se ha subido
    if (!empty($_FILES['foto']['name'])) {

        $id = $db->obtenerSiguienteID(); // Obtener el ID del cliente
        // Obtener la extensión de la imagen
        $foto_name = sprintf("%08d", $id) . "." . $extension; // Generar el nombre de la imagen con el formato especificado
        $foto_path = "./app/uploads/" . $foto_name; // Generar la ruta completa de la imagen

        // Verificar si la imagen es válida y moverla al directorio de uploads
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
            $cli->foto = $foto_path; // Asignar la ruta de la imagen al objeto Cliente
        } else {
            $errores[] = "-Error al subir la imagen.";
        }
    }

    // Añadir el cliente a la base de datos
    if ($db->addCliente($cli)) {
        $_SESSION['msg'] = "El usuario " . $cli->first_name . " se ha dado de alta.";
    } else {
        $_SESSION['msg'] = "Error al dar de alta al usuario " . $cli->first_name . ".";
    }
}

function crudPostModificar()
{
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $cli = new Cliente();

    $cli->id            = $_POST['id'];
    $cli->first_name    = $_POST['first_name'];
    $cli->last_name     = $_POST['last_name'];
    $cli->email         = $_POST['email'];
    $cli->gender        = $_POST['gender'];
    $cli->ip_address    = $_POST['ip_address'];
    $cli->telefono      = $_POST['telefono'];

    // Validar que los datos sean correctos
    $errores = [];

    //Verificar correo
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "-La estructura del correo no es válida.<br>";
    }

    // Verificar formato de la IP
    if (!filter_var($_POST['ip_address'], FILTER_VALIDATE_IP)) {
        $errores[] = "-El formato de la dirección IP no es válido.<br>";
    }

    // Verificar formato de teléfono (XXX-XXX-XXXX)
    if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $_POST['telefono'])) {
        $errores[] = "-El formato del teléfono no es válido. Debe ser XXX-XXX-XXXX.<br>";
    }

    // Verificar que el correo electrónico no exista en otro usuario
    $db = AccesoDatos::getModelo();
    if ($db->existeEmail($cli->id, $cli->email)) {
        $errores[] = "-El correo electrónico ya está registrado en otro usuario.";
    }

    // Verificar si se ha subido una imagen
    if (!empty($_FILES['foto']['name'])) {
        $allowed_types = array('jpg', 'JPG', 'png', 'PNG');
        $temp = explode('.', $_FILES['foto']['name']);
        $extension = strtolower(end($temp)); // Convertir la extensión a minúsculas para evitar problemas con la comparación

        if (!in_array($extension, $allowed_types)) {
            $errores[] = "-La foto debe ser una imagen JPG o PNG.";
        }
    }

    // Si hay errores, mostrar mensaje y detener el proceso
    if (!empty($errores)) {
        $_SESSION['msg'] = "Error al modificar el usuario: <br>" . implode(" ", $errores);
        return;
    }

    // Guardar la foto si se ha subido
    if (!empty($_FILES['foto']['name'])) {
        $id = $_POST['id']; // Obtener el ID del cliente
        $foto_name = sprintf("%08d", $id) . "." . $extension; // Generar el nombre de la imagen con el formato especificado
        $foto_path = "./app/uploads/" . $foto_name; // Generar la ruta completa de la imagen

        // Verificar si ya existe una imagen con otra extensión y eliminarla
        $existing_extensions = array_diff($allowed_types, array($extension));
        foreach ($existing_extensions as $ext) {
            $existing_image = "./app/uploads/" . sprintf("%08d", $id) . "." . $ext;
            if (file_exists($existing_image)) {
                unlink($existing_image); // Eliminar el archivo existente
            }
        }

        // Mover la nueva imagen al directorio de uploads
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
            $cli->foto = $foto_path; // Asignar la ruta de la imagen al objeto Cliente
            $_SESSION['msg'] .= "-Se ha modificado la imagen.<br>";
        } else {
            $_SESSION['msg'] .= "-Error al subir la imagen.<br>";
            return;
        }
    }

    // Si los datos son correctos, continuar con el proceso de modificación del cliente
    if ($db->modCliente($cli)) {
        $_SESSION['msg'] .= "-El usuario ha sido modificado.";
    } else {
        $_SESSION['msg'] .= "-No se ha modificado el usuario.";
    }
}

function crudModificarSiguiente($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    $orden = "Modificar";
    include_once "app/views/formulario.php";
}

function crudModificarAnterior($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    $orden = "Modificar";
    include_once "app/views/formulario.php";
}

function obtenerBandera($cli): array
{
 $loc = file_get_contents('http://ip-api.com/json/' . $cli->ip_address);

    $obj = json_decode($loc);

    if (property_exists($obj, "countryCode")) {

        $pais = strtolower($obj->countryCode);

        $bandera = array(

            "pais" => $pais,

            "url" => 'https://flagcdn.com/h120/' . $pais . '.jpg',

            "msg" => '<img src="https://flagcdn.com/h120/' . $pais . '.jpg" alt="' . $obj->country . '">'

        );
    } else {

        $bandera = array(

            "url" => 'https://banderasysoportes.com/xen_media/bandera-pirata.jpg',
            "msg" => '<img src="https://banderasysoportes.com/xen_media/bandera-pirata.jpg" alt="bandera pirata">'

        );
    }

    return $bandera;
}


function mostrarImagenCliente($id)
{
    // Ruta donde se encuentran las imágenes de los clientes
    $rutaImagenes = "./app/uploads/";

    // Verificar si la imagen asociada al cliente existe con extensión JPG
    $nombreArchivoJPG = sprintf("%08d", $id) . ".jpg";
    $rutaCompletaJPG = $rutaImagenes . $nombreArchivoJPG;

    // Verificar si la imagen asociada al cliente existe con extensión PNG
    $nombreArchivoPNG = sprintf("%08d", $id) . ".png";
    $rutaCompletaPNG = $rutaImagenes . $nombreArchivoPNG;

    if (file_exists($rutaCompletaJPG)) {
        $imagen = array(
            "url" => $rutaCompletaJPG,
            "msg" => '<img src="' . $rutaCompletaJPG . '" alt="Imagen del cliente">'
        );
    } elseif (file_exists($rutaCompletaPNG)) {
        $imagen = array(
            "url" => $rutaCompletaPNG,
            "msg" => '<img src="' . $rutaCompletaPNG . '" alt="Imagen del cliente">'
        );
    } else {
        $hash = md5($id); // Usar el id del cliente como semilla para generar el hash
        $imagenPorDefecto = "https://robohash.org/{$hash}?set=set1"; // URL de robohash.org
        $imagen = array(
            "url" => $imagenPorDefecto,
            "msg" => '<img src="' . $imagenPorDefecto . '" alt="Imagen por defecto">'
        );
    }
    return $imagen;
}


function generarPdf($id)
{

    $db = AccesoDatos::getModelo();

    $cli = $db->getCliente($id);



    $pdf = new FPDF();

    $pdf->AddPage();

    $posicionY_inicial = 20;

    $pdf->SetFillColor(232, 232, 232);



    $pdf->SetFont('Arial', 'B', 12);

    $pdf->SetY($posicionY_inicial);

    $pdf->SetX(40);

    $pdf->Cell(30, 6, 'ID', 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(40);

    $pdf->Cell(30, 6, 'NOMBRE', 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(40);

    $pdf->Cell(30, 6, 'APELLIDO', 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(40);

    $pdf->Cell(30, 6, 'CORREO', 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(40);

    $pdf->Cell(30, 6, 'GENERO', 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(40);

    $pdf->Cell(30, 6, 'IP', 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(40);

    $pdf->Cell(30, 6, 'TELEFONO', 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(40);

    $pdf->Cell(30, 30, 'FOTO', 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(40);

    $pdf->Cell(30, 30, 'PAIS', 1, 0, 'L', 1);



    $pdf->SetFont('Arial', '', 12);

    $pdf->SetY($posicionY_inicial);

    $pdf->SetX(70);

    $pdf->Cell(100, 6, $cli->id, 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(70);

    $pdf->Cell(100, 6, $cli->first_name, 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(70);

    $pdf->Cell(100, 6, $cli->last_name, 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(70);

    $pdf->Cell(100, 6, $cli->email, 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(70);

    $pdf->Cell(100, 6, $cli->gender, 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(70);

    $pdf->Cell(100, 6, $cli->ip_address, 1, 0, 'L', 1);

    $pdf->Ln();

    $pdf->SetX(70);

    $pdf->Cell(100, 6, $cli->telefono, 1, 0, 'L', 1);


    $pdf->Ln();

    $pdf->SetX(70);


    $url = mostrarImagenCliente($id)["url"];
    $extension = pathinfo($url, PATHINFO_EXTENSION);

    if ($extension === "jpg") {
        $pdf->Image($url, null, null, 0, 30, "jpg");
    } else {
        $pdf->Image($url, null, null, 0, 30, "png");
    }




    $pdf->SetX(70);

    if (array_key_exists("url", obtenerBandera($cli))) {

        $pdf->Image(obtenerBandera($cli)["url"], null, null, 0, 30);
    } else {
        $pdf->Image(obtenerBandera($cli)["msg"], null, null, 0, 30);

        $pdf->Ln();
    }


    $nombre_pdf = "$cli->first_name" . "$cli->last_name _Detalles";

    $pdf->Output("", "$nombre_pdf", "");
}
