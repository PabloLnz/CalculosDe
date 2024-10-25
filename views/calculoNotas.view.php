<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Calculo De Notas</h1>
</div>
<!-- Content Row -->
<div class="row">
    <!-- Formulario para enviar el JSON y mostrar el errores si hay -->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Datos asignaturas</h6>
            </div>
            <div class="card-body">
                <form method="post" action="./?sec=calculoNotas">
                    <div class="mb-3">
                        <label for="texto">Datos a analizar (JSON):</label>
                        <textarea class="form-control" name="texto" id="texto" rows="10"
                                  placeholder="Inserte el json a analizar"><?php echo isset($data['input']['texto']) ? $data['input']['texto'] : ''; ?></textarea>
                        <p class="text-danger small"><?php echo isset($data['errors']['texto']) ? implode('<br>', $data['errors']['texto']) : ''; ?></p>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Si hay resultados, muestra las tablas y listados -->
    <?php if (isset($data['resultado'])) { ?>
        <div class="col-12">
            <!-- Resultados por asignatura -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Resultados por asignatura</h6>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Asignatura</th>
                            <th>Media</th>
                            <th>Suspensos</th>
                            <th>Aprobados</th>
                            <th>Nota más alta</th>
                            <th>Nota mínima</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['resultado'] as $asignatura => $datos) { ?>
                            <tr>
                                <td><?php echo $asignatura; ?></td>
                                <td><?php echo is_numeric($datos['media']) ? number_format($datos['media'], 2, ',') : $datos['media']; ?></td>
                                <td><?php echo $datos['suspensos']; ?></td>
                                <td><?php echo $datos['aprobados']; ?></td>
                                <td><?php echo $datos['max']['alumno']; ?>
                                    : <?php echo round($datos['max']['nota']); ?></td>
                                <td><?php echo $datos['min']['alumno']; ?>
                                    : <?php echo round($datos['min']['nota']); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Listados de alumnos -->
        <div class="col-12 col-lg-6">
            <div class="alert alert-success">
                <h6 class="m-0 font-weight-bold text-primary">Alumnos que han aprobado todo</h6>
                <ul>
                    <?php foreach ($data['listas']['aprobadoTodo'] as $alumno) { ?>
                        <li><?php echo $alumno; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!--Alumnos suspenden 1-->
        <div class="col-12 col-lg-6">
            <div class="alert alert-warning">
                <h6 class="m-0 font-weight-bold text-primary">Alumnos que han suspendido al menos una asignatura</h6>
                <ul>
                    <?php foreach ($data['listas']['suspendidoAlMenosUna'] as $alumno) { ?>
                        <li><?php echo $alumno; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!--Alumnos que promocionan-->
        <div class="col-12 col-lg-6">
            <div class="alert alert-info">
                <h6 class="m-0 font-weight-bold text-primary">Alumnos que promocionan</h6>
                <ul>
                    <?php foreach ($data['listas']['promocionan'] as $alumno) { ?>
                        <li><?php echo $alumno; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!--Alumnos que no promocionan-->
        <div class="col-12 col-lg-6">
            <div class="alert alert-danger">
                <h6 class="m-0 font-weight-bold text-primary">Alumnos que no promocionan</h6>
                <ul>
                    <?php foreach ($data['listas']['noPromocionan'] as $alumno) { ?>
                        <li><?php echo $alumno; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>
</div>
