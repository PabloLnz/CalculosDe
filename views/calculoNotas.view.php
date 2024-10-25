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
                        <textarea class="form-control" name="texto" id="texto" rows="10" placeholder="Inserte el json a analizar"><?php echo isset($data['input']['texto']) ? $data['input']['texto'] : ''; ?></textarea>
                        <p class="text-danger small"><?php echo isset($data['errors']['texto']) ? implode('<br>', $data['errors']['texto']) : ''; ?></p>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>