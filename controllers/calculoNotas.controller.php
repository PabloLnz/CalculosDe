<?php
declare(strict_types=1);

$data = [];

if (!empty($_POST)) {
    $data['errors'] = checkErrors($_POST['texto']);
    $data['input']['texto'] = filter_var($_POST['texto'], FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($data['errors'])) {
        $datos = json_decode($_POST['texto'], true);
        $data['resultado'] = procesar($datos);
        $data['listas'] = calcularListados($datos);
    }
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
//Funcion que procesa las calficaciones por asignatura y devuleve os resultados
function procesar(array $datos): array {
    $resultado = [];
    foreach ($datos as $asignatura => $alumnos) {
        $datosAsignatura = [];
        $sumatorio = 0;
        $suspensos = 0;
        $aprobados = 0;
        $max = ['alumno' => 'N/A', 'nota' => -1];
        $min = ['alumno' => 'N/A', 'nota' => 11];

        foreach ($alumnos as $alumno => $notas) {
            $mediaAlumno = array_sum($notas) / count($notas);
            $sumatorio += $mediaAlumno;

            if ($mediaAlumno < 5) {
                $suspensos++;
            } else {
                $aprobados++;
            }

            if ($mediaAlumno > $max['nota']) {
                $max = ['alumno' => $alumno, 'nota' => $mediaAlumno];
            }
            if ($mediaAlumno < $min['nota']) {
                $min = ['alumno' => $alumno, 'nota' => $mediaAlumno];
            }
        }

        $datosAsignatura['media'] = !empty($alumnos) ? $sumatorio / count($alumnos) : '-';
        $datosAsignatura['suspensos'] = $suspensos;
        $datosAsignatura['aprobados'] = $aprobados;
        $datosAsignatura['max'] = $max;
        $datosAsignatura['min'] = $min;

        $resultado[$asignatura] = $datosAsignatura;
    }
    return $resultado;
}

//Funcion para comprobar que el JSON este bien formado
function checkErrors(string $texto): array {
    $errors = [];
    if (empty($texto)) {
        $errors['texto'][] = 'Inserte un JSON a analizar';
    } else {
        $datos = json_decode($texto, true);
        if (is_null($datos)) {
            $errors['texto'][] = 'El texto introducido no es un JSON bien formado';
        } else {
            if (!is_array($datos)) {
                $errors['texto'][] = 'El JSON no contiene un array de materias';
            } else {
                foreach ($datos as $asignatura => $alumnos) {
                    if (!is_string($asignatura) || mb_strlen(trim($asignatura)) < 1) {
                        $errors['texto'][] = "'$asignatura' no es un nombre de asignatura válido";
                    }
                    if (!is_array($alumnos)) {
                        $errors['texto'][] = "'$asignatura' no contiene un array de alumnos";
                    } else {
                        foreach ($alumnos as $alumno => $notas) {
                            if (!is_string($alumno) || mb_strlen(trim($alumno)) < 1) {
                                $errors['texto'][] = "El alumno '$alumno' de la asignatura '$asignatura' no es un nombre de alumno válido";
                            }
                            if (!is_array($notas)) {
                                $errors['texto'][] = "Las notas del alumno '$alumno' en la asignatura '$asignatura' no son un array";
                            } else {
                                foreach ($notas as $nota) {
                                    if (!is_numeric($nota)) {
                                        $errors['texto'][] = "La nota '$nota' del alumno '$alumno' en la asignatura '$asignatura' no es un número";
                                    } elseif ($nota < 0 || $nota > 10) {
                                        $errors['texto'][] = "La nota '$nota' del alumno '$alumno' en la asignatura '$asignatura' no tiene un valor entre 0 y 10";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $errors;
}


include 'views/templates/header.php';
include 'views/calculoNotas.view.php';
include 'views/templates/footer.php';


