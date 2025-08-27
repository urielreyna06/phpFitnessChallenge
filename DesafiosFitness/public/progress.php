<?php
require_once '../config/config.php';
require_once DB_PATH . '/db.php';
require_once LIB_PATH . '/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$mensaje = '';

// Obtener desafíos activos del usuario
$stmt = $conn->prepare("SELECT uc.id AS uc_id, c.title FROM user_challenges uc JOIN challenges c ON uc.challenge_id = c.id WHERE uc.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$desafios = [];
while ($row = $result->fetch_assoc()) {
    $desafios[] = $row;
}
$stmt->close();

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uc_id = $_POST['user_challenge_id'];
    $fecha = $_POST['date'];
    $detalle = $_POST['detail'];
    $progreso = intval($_POST['progress']);

    $stmt = $conn->prepare("INSERT INTO progress (user_challenge_id, date, detail, progress) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $uc_id, $fecha, $detalle, $progreso);

    if ($stmt->execute()) {
        $update = $conn->prepare("UPDATE user_challenges SET progreso = ? WHERE id = ?");
        $update->bind_param("ii", $progreso, $uc_id);
        $update->execute();
        $update->close();
        $mensaje = "✅ Actividad registrada con éxito.";
    } else {
        $mensaje = "❌ Error al registrar la actividad.";
    }
    $stmt->close();
}
?>

<?php include INCLUDES_PATH . '/header.php'; ?>

<div class="card fade-in" style="max-width: 700px; margin: 40px auto;">
    <h2 style="text-align:center;">Registrar Actividad</h2>
    <p style="text-align:center;">Selecciona el desafío y actualiza tu progreso.</p>

    <?php if ($mensaje): ?>
        <div class="message <?= str_contains($mensaje, '✅') ? 'success' : 'error' ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <?php if (count($desafios) > 0): ?>
        <form method="POST" class="fade-in">
            <label for="user_challenge_id">Desafío:</label>
            <select name="user_challenge_id" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($desafios as $d): ?>
                    <option value="<?= $d['uc_id'] ?>"><?= htmlspecialchars($d['title']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="date">Fecha:</label>
            <input type="date" name="date" required>

            <label for="detail">Detalle de la actividad:</label>
            <textarea name="detail" rows="3" placeholder="Ej: 30 minutos de cardio, rutina de piernas..." required></textarea>

            <label for="progress">Nuevo progreso (%):</label>
            <input type="number" name="progress" min="1" max="100" required>

            <button type="submit">Guardar progreso</button>
        </form>
    <?php else: ?>
        <p style="text-align: center; margin-top: 20px;">No tienes desafíos activos en este momento.</p>
    <?php endif; ?>
</div>

<?php include INCLUDES_PATH . '/footer.php'; ?>
