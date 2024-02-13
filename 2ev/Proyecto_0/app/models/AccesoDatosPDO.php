<?php

/*
 * Acceso a datos con BD Usuarios : 
 * Usando la librería PDO *******************
 * Uso el Patrón Singleton :Un único objeto para la clase
 * Constructor privado, y métodos estáticos 
 */
class AccesoDatos
{

    private static $modelo = null;
    private $dbh = null;

    public static function getModelo()
    {
        if (self::$modelo == null) {
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }



    // Constructor privado  Patron singleton

    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DATABASE . ";charset=utf8";
            $this->dbh = new PDO($dsn, DB_USER, DB_PASSWD);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión " . $e->getMessage();
            exit();
        }
    }

    // Cierro la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModelo()
    {
        if (self::$modelo != null) {
            $obj = self::$modelo;
            // Cierro la base de datos
            $obj->dbh = null;
            self::$modelo = null; // Borro el objeto.
        }
    }


    // Devuelvo cuantos filas tiene la tabla

    public function numClientes(): int
    {
        $result = $this->dbh->query("SELECT id FROM Clientes");
        $num = $result->rowCount();
        return $num;
    }


    // SELECT Devuelvo la lista de Usuarios
    public function getClientes($primero, $cuantos): array
    {
        $tuser = [];
        $orden = $_SESSION["orden"];

        $stmt_usuarios  = $this->dbh->prepare("SELECT * FROM Clientes ORDER BY $orden LIMIT $primero, $cuantos");
        // Si falla termina el programa
        $stmt_usuarios->setFetchMode(PDO::FETCH_CLASS, 'Cliente');

        if ($stmt_usuarios->execute()) {
            while ($user = $stmt_usuarios->fetch()) {
                $tuser[] = $user;
            }
        }
        // Devuelvo el array de objetos
        return $tuser;
    }


    // SELECT Devuelvo un usuario o false
    public function getCliente(int $id)
    {
        $cli = false;
        $stmt_cli   = $this->dbh->prepare("select * from Clientes where id=:id");
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $stmt_cli->bindParam(':id', $id);
        if ($stmt_cli->execute()) {
            if ($obj = $stmt_cli->fetch()) {
                $cli = $obj;
            }
        }
        return $cli;
    }


    public function getClienteSiguiente($id)
    {

        $cli = false;
        $campo = $_SESSION["orden"];

        // Primero, intentamos obtener el siguiente cliente
        $stmt_cli = $this->dbh->prepare("SELECT * FROM Clientes WHERE $campo > (SELECT $campo FROM Clientes WHERE id = ?) ORDER BY $campo ASC LIMIT 1");
        $stmt_cli->bindParam(1, $id);
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        if ($stmt_cli->execute()) {
            if ($obj = $stmt_cli->fetch()) {
                $cli = $obj;
            }
        }

        // Si no se encontró el siguiente cliente, buscamos el primero
        if (!$cli) {
            $stmt_cli = $this->dbh->prepare("SELECT * FROM Clientes ORDER BY $campo ASC LIMIT 1");
            $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
            if ($stmt_cli->execute()) {
                if ($obj = $stmt_cli->fetch()) {
                    $cli = $obj;
                }
            }
        }

        return $cli;
    }

    public function getClienteAnterior($id)
    {

        $cli = false;
        $campo = $_SESSION["orden"];

        // Primero, intentamos obtener el cliente anterior
        $stmt_cli = $this->dbh->prepare("SELECT * FROM Clientes WHERE $campo < (SELECT $campo FROM Clientes WHERE id = ?) ORDER BY $campo DESC LIMIT 1");
        $stmt_cli->bindParam(1, $id);
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        if ($stmt_cli->execute()) {
            if ($obj = $stmt_cli->fetch()) {
                $cli = $obj;
            }
        }

        // Si no se encontró el cliente anterior, buscamos el último
        if (!$cli) {
            $stmt_cli = $this->dbh->prepare("SELECT * FROM Clientes ORDER BY $campo DESC LIMIT 1");
            $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
            if ($stmt_cli->execute()) {
                if ($obj = $stmt_cli->fetch()) {
                    $cli = $obj;
                }
            }
        }

        return $cli;
    }




    // UPDATE TODO
    public function modCliente($cli): bool
    {

        $stmt_moduser   = $this->dbh->prepare("update Clientes set first_name=:first_name,last_name=:last_name" .
            ",email=:email,gender=:gender, ip_address=:ip_address,telefono=:telefono WHERE id=:id");
        $stmt_moduser->bindValue(':first_name', $cli->first_name);
        $stmt_moduser->bindValue(':last_name', $cli->last_name);
        $stmt_moduser->bindValue(':email', $cli->email);
        $stmt_moduser->bindValue(':gender', $cli->gender);
        $stmt_moduser->bindValue(':ip_address', $cli->ip_address);
        $stmt_moduser->bindValue(':telefono', $cli->telefono);
        $stmt_moduser->bindValue(':id', $cli->id);

        $stmt_moduser->execute();
        $resu = ($stmt_moduser->rowCount() == 1);
        return $resu;
    }


    //INSERT 
    public function addCliente($cli): bool
    {

        // El id se define automáticamente por autoincremento.
        $stmt_crearcli  = $this->dbh->prepare(
            "INSERT INTO `Clientes`( `first_name`, `last_name`, `email`, `gender`, `ip_address`, `telefono`)" .
                "Values(?,?,?,?,?,?)"
        );
        $stmt_crearcli->bindValue(1, $cli->first_name);
        $stmt_crearcli->bindValue(2, $cli->last_name);
        $stmt_crearcli->bindValue(3, $cli->email);
        $stmt_crearcli->bindValue(4, $cli->gender);
        $stmt_crearcli->bindValue(5, $cli->ip_address);
        $stmt_crearcli->bindValue(6, $cli->telefono);
        $stmt_crearcli->execute();
        $resu = ($stmt_crearcli->rowCount() == 1);
        return $resu;
    }


    //DELETE 
    public function borrarCliente(int $id): bool
    {


        $stmt_boruser   = $this->dbh->prepare("delete from Clientes where id =:id");

        $stmt_boruser->bindValue(':id', $id);
        $stmt_boruser->execute();
        $resu = ($stmt_boruser->rowCount() == 1);
        return $resu;
    }


    // Evito que se pueda clonar el objeto. (SINGLETON)
    public function __clone()
    {
        trigger_error('La clonación no permitida', E_USER_ERROR);
    }

    public function existeEmail($id, $email)
    {
        // Preparar la consulta SQL para verificar si el correo existe en otro usuario
        $query = "SELECT COUNT(*) FROM Clientes WHERE id != :id AND email = :email";
        $stmt = $this->dbh->prepare($query);
        // Bind de parámetros
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener el resultado
            $result = $stmt->fetchColumn();
            // Si el resultado es mayor que cero, significa que el correo existe en otro usuario
            return $result > 0;
        } else {
            // Si hay algún error en la consulta, retornamos false
            return false;
        }
    }
    public function obtenerSiguienteID()
    {
        $query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = :database_name AND TABLE_NAME = 'Clientes'";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['database_name' => 'clientes']);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['AUTO_INCREMENT'];
    }
}