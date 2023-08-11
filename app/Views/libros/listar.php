<?= $cabecera ?>
<a class="btn btn-success" href="<?= base_url('crear') ?>">Crear un libro</a>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($libros as $libro) : ?>

            <tr>
                <td><?= $libro['id'] ?></td>
                <td>
                    <img class="img-thumbnail" src="<?= base_url() ?>/uploads/<?= $libro['imagen'] ?>" width="100" height="100" alt="imagen">
                </td>
                <td><?= $libro['nombre'] ?></td>
                <td>
                    <a href="<?= base_url('editar/' . $libro['id']) ?>" class="btn btn-info" type="button">Editar</a>
                    <a href="<?= base_url('borrar/' . $libro['id']) ?>" class="btn btn-danger" type="button">Borrar</a>
                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>
<?= $pie ?>