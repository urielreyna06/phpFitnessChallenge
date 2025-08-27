<?php
header("Content-Type: application/json");
require_once '../config/config.php';
require_once '../db/db.php';

if (!isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Falta el parámetro 'user_id'"]);
    exit;
}

$user_id = intval($_GET['user_id']);

// Obtener resumen de desafíos
$sql = "SELECT c.nombre AS desafio, uc.progreso, COUNT(a.id) AS actividades
        FROM user_challenges uc
        LEFT JOIN challenges c ON uc.challenge_id = c.id
        LEFT JOIN activities a ON a.user_id = uc.user_id AND a.challenge_id = uc.challenge_id
        WHERE uc.user_id = ?
        GROUP BY c.nombre, uc.progreso";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "desafio"     => $row['desafio'],
        "progreso"    => intval($row['progreso']),
        "actividades" => intval($row['actividades']),
    ];
}

echo json_encode([
    "usuario" => $user_id,
    "resumen" => $data
]);
