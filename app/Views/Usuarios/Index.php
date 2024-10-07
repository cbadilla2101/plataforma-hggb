<h1>Usuarios</h1>

<table class="table">
    <thead>
        <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= $usuario->us_nombres ?></td>
                <td><?= $usuario->us_ap . " " . $usuario->us_am ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>