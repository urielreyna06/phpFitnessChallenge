<?php
function getExerciseInfo($type) {
    $exercises = [
        "correr" => [
            "beneficio" => "Mejora la salud cardiovascular",
            "recomendacion" => "3 veces por semana"
        ],
        "pesas" => [
            "beneficio" => "Aumenta la masa muscular",
            "recomendacion" => "2 veces por semana"
        ],
        "yoga" => [
            "beneficio" => "Mejora flexibilidad y reduce estrés",
            "recomendacion" => "Diariamente o en días alternos"
        ],
        "hiit" => [
            "beneficio" => "Quema grasa y mejora resistencia",
            "recomendacion" => "2 a 3 veces por semana"
        ]
    ];

    return $exercises[$type] ?? ["error" => "Tipo de ejercicio no reconocido"];
}

$server = new SoapServer(null, [
    'uri' => "http://localhost/DesafiosFitness/public/"
]);

$server->addFunction("getExerciseInfo");
$server->handle();
