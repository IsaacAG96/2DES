<form>
    <button type="submit" name="orden" value="Nuevo"> Cliente Nuevo </button><br>

    <br>

    <table>
        <tr>
            <th><input type="submit" name="ordenar" value="id"></th>
            <th><input type="submit" name="ordenar" value="first_name"></th>
            <th><input type="submit" name="ordenar" value="email"></th>
            <th><input type="submit" name="ordenar" value="gender"></th>
            <th><input type="submit" name="ordenar" value="ip_address"></th>
            <th><input type="submit" name="ordenar" value="telefono"></th>
        </tr>
        <?php foreach ($tvalores as $valor) : ?>
            <tr>
                <td><?= $valor->id ?> </td>
                <td><?= $valor->first_name ?> </td>
                <td><?= $valor->email ?> </td>
                <td><?= $valor->gender ?> </td>
                <td><?= $valor->ip_address ?> </td>
                <td><?= $valor->telefono ?> </td>
                <td><a href="#" onclick="confirmarBorrar('<?= $valor->first_name ?>',<?= $valor->id ?>);">Borrar</a></td>
                <td><a href="?orden=Modificar&id=<?= $valor->id ?>">Modificar</a></td>
                <td><a href="?orden=Detalles&id=<?= $valor->id ?>">Detalles</a></td>

            <tr>
            <?php endforeach ?>
    </table>
</form>
<form>
    <br>
    <button type="submit" name="nav" value="Primero">
        << </button>
            <button type="submit" name="nav" value="Anterior">
                < </button>
                    <button type="submit" name="nav" value="Siguiente"> > </button>
                    <button type="submit" name="nav" value="Ultimo"> >> </button>
</form>