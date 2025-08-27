<?php
header("Content-Type: application/json");
include '../config/config.php';
include '../db/db.php';

// Permitir solo solicitudes GET
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Método no permitido. Usa GET."]);
    exit;
}

// Obtener desafíos con conteo de usuarios inscritos
$sql = "
    SELECT 
        c.id,
        c.title,
        COUNT(uc.user_id) AS inscritos
    FROM challenges c
    LEFT JOIN user_challenges uc ON c.id = uc.challenge_id
    GROUP BY c.id, c.title
";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id" => $row["id"],
        "titulo" => $row["title"],
        "inscritos" => (int) $row["inscritos"]
    ];
}

// Devolver los datos como JSON
echo json_encode($data);
