<?php

    require_once "Layout/layout.php";
    $layout = new Layout ( true );

?>
<?php echo $layout->printHeader (); ?>
<div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2"></div>
    </div>
        <hr  />
    <div class="row">
        <?php if ( count ( $estudiantes ) == 0 ) : ?>
            <h2>No hay alumno alguno agregado.</h2>
        <?php else : ?>
            <?php foreach ( $estudiantes as $estudiante ) : ?>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <img class="card-img" src="<?= "Funciones/Fotos/" . $estudiante->foto ?>"  />
                                <hr  />
                            <h6 class="card-title"><b><?= $estudiante->nombre . " " . $estudiante->apellido ?>.</b></h6>
                            <p class="card-text"><?= $estudiante->status ?></p>
                            <p class="card-text">Carrera: <?= $utilities->carreras [ $estudiante->carrera ] ?>.</p>
                            <p class="card-text">La/s materia/s que me gusta/n:<br  /><?= $estudiante->materia ?>.</p>
                            <a href="Funciones/edit.php?id=<?= $estudiante->id ?>" class="btn btn-success">Editar</a>
                            <a href="Funciones/delete.php?id=<?= $estudiante->id ?>" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<br  /><br  />
<?php echo $layout->printFooter (); ?>