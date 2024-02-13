<hr>
<form method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>id:</td>
            <td><input type="number" name="id" value="<?= $cli->id ?>" readonly></td>
        </tr>
        <tr>
            <td>first_name:</td>
            <td><input type="text" name="first_name" value="<?= $cli->first_name ?>" autofocus></td>
        </tr>
        <tr>
            <td>last_name:</td>
            <td><input type="text" name="last_name" value="<?= $cli->last_name ?>"></td>
        </tr>
        <tr>
            <td>email:</td>
            <td><input type="email" name="email" value="<?= $cli->email ?>"></td>
        </tr>
        <tr>
            <td>gender</td>
            <td><input type="text" name="gender" value="<?= $cli->gender ?>"></td>
        </tr>
        <tr>
            <td>ip_address:</td>
            <td><input type="text" name="ip_address" value="<?= $cli->ip_address ?>"></td>
        </tr>
        <tr>
            <td>telefono:</td>
            <td><input type="tel" name="telefono" value="<?= $cli->telefono ?>"></td>
        </tr>
        <tr>
            <td>imagen:</td>
            <td><input type="file" name="foto" accept="image/jpeg, image/png" size="500000"></td>
        </tr>
    </table>
    <input type="submit" name="orden" value="<?= $orden ?>">
    <input type="submit" name="orden" value="Volver">
</form>

<?php
if (!isset($_GET["orden"]) || $_GET["orden"] != "Nuevo") {
?>
    <form method="GET">
        <input type="hidden" name="id" value="<?= $cli->id ?>">
        <button type="submit" name="nav-modificar" value="Anterior"><< Anterior</button>
        <button type="submit" name="nav-modificar" value="Siguiente">Siguiente >></button>
    </form>
<?php
}
?>