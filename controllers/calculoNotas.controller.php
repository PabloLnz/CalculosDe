<?php
declare(strict_types=1);

$data = [];

if (!empty($_POST)) {
    $data['errors'] = checkErrors($_POST['texto']);
    $data['input']['texto'] = filter_var($_POST['texto'], FILTER_SANITIZE_SPECIAL_CHARS);
}

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


