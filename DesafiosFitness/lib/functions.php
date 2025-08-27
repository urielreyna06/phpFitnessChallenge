<?php

// ✅ Obtener nombre de usuario desde su ID
function obtenerNombreUsuario($conn, $user_id): string {
    $stmt = $conn->prepare("SELECT username FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $username = ''; // 🛠️ Inicializar antes de bind_result
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();

    return $username;
}

// ✅ Obtener estadísticas del usuario (actividades, calorías, duración, tipo más frecuente)
function obtenerEstadisticasUsuario($conn, $user_id): array {
    $stats = [
        'total_actividades' => 0,
        'total_calorias' => 0,
        'total_duracion' => 0,
        'actividad_mas_frecuente' => 'Ninguna'
    ];

    // 🟣 Totales generales
    $sql = "SELECT COUNT(*), SUM(calories), SUM(duration) FROM activities WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $total = 0; $calorias = 0; $duracion = 0; // 🛠️ Inicializar variables
    $stmt->bind_result($total, $calorias, $duracion);
    $stmt->fetch();
    $stmt->close();

    $stats['total_actividades'] = $total ?? 0;
    $stats['total_calorias'] = $calorias ?? 0;
    $stats['total_duracion'] = $duracion ?? 0;

    // 🟣 Actividad más frecuente
    $sql2 = "SELECT type, COUNT(*) FROM activities WHERE user_id = ? GROUP BY type ORDER BY COUNT(*) DESC LIMIT 1";
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $tipo = ''; $cantidad = 0;
    $stmt->bind_result($tipo, $cantidad);
    if ($stmt->fetch()) {
        $stats['actividad_mas_frecuente'] = $tipo;
    }
    $stmt->close();

    return $stats;
}

// ✅ Verifica si el usuario está inscrito en un desafío específico
function usuarioInscritoEnDesafio($conn, $user_id, $challenge_id): bool {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user_challenges WHERE user_id = ? AND challenge_id = ?");
    $stmt->bind_param("ii", $user_id, $challenge_id);
    $stmt->execute();

    $existe = 0; // 🛠️ Inicializar
    $stmt->bind_result($existe);
    $stmt->fetch();
    $stmt->close();

    return $existe > 0;
}

// ✅ Retorna todos los desafíos activos del usuario
function obtenerDesafiosActivos($conn, $user_id): array {
    $stmt = $conn->prepare("
        SELECT c.id, c.title, c.description, c.duration 
        FROM user_challenges uc 
        INNER JOIN challenges c ON uc.challenge_id = c.id 
        WHERE uc.user_id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $desafios = [];
    while ($row = $result->fetch_assoc()) {
        $desafios[] = $row;
    }

    return $desafios;
}
