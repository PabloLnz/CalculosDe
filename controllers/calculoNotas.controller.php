<?php
declare(strict_types=1);

$data = [];

if (!empty($_POST)) {
    $data['errors'] = checkErrors($_POST['texto']);
    $data['input']['texto'] = filter_var($_POST['texto'], FILTER_SANITIZE_SPECIAL_CHARS);
}

//Funcion para almacenar a los alumnos segun sus aprobados y suspensos
function calcularListados(array $datos): array
{
    $aprobadoTodo = [];
    $suspendidoAlMenosUna = [];
    $promocionan = [];
    $noPromocionan = [];

    foreach ($datos as $asignaturas) {
        foreach ($asignaturas as $alumno => $notas) {
            $suspensos = 0;
            foreach ($notas as $nota) {
                if ($nota < 5) {
                    $suspensos++;
                }
            }
            if ($suspensos == 0) {
                $aprobadoTodo[$alumno]=$alumno ;
            } elseif ($suspensos == 1) {
                $promocionan[$alumno]=$alumno;
            } else {
                $noPromocionan[$alumno]=$alumno;
            }
            if ($suspensos > 0) {
                $suspendidoAlMenosUna[$alumno] = $alumno;
            }
        }
    }
    return ['aprobadoTodo' => $aprobadoTodo, 'promocionan' => $promocionan, 'noPromocionan' => $noPromocionan,'suspendidoAlMenosUna' => $suspendidoAlMenosUna];

}


//Funcion para comprobar que el JSON este bien formado
function checkErrors(string $texto): array
{
    $errors = [];
    if (empty($texto)) {
        $errors['texto'][] = 'Inserte un JSON a analizar';
    } else {
        $datos = json_decode($texto, true);
        if (is_null($datos)) {
            $errors['texto'][] = 'El texto introducido no es un JSON bien formado';
        }


    }
    return $errors;
}


include 'views/templates/header.php';
include 'views/calculoNotas.view.php';
include 'views/templates/footer.php';


