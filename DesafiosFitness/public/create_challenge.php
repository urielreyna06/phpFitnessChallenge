<?php
require_once '../config/config.php';
require_once DB_PATH . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['title']);
    $descripcion = trim($_POST['description']);
    $duracion = intval($_POST['duration']);
    $objetivos = trim($_POST['objectives']);

    if (empty($titulo) || empty($descripcion) || $duracion <= 0) {
        $error = "⚠️ Todos los campos obligatorios deben estar completos.";
    } else {
        $stmt = $conn->prepare("INSERT INTO challenges (title, description, duration, objectives) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $titulo, $descripcion, $duracion, $objetivos);

        if ($stmt->execute()) {
            $mensaje = "✅ Desafío creado correctamente.";
        } else {
            $error = "❌ Ocurrió un error al crear el desafío.";
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="card fade-in" style="max-width: 700px; margin: 40px auto;">
    <h2 class="text-center">Crear nuevo desafío</h2>

    <?php if ($mensaje): ?>
        <div class="message success"><?= $mensaje ?></div>
    <?php elseif ($error): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="title">Título del desafío:</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Descripción:</label>
        <textarea name="description" id="description" rows="3" required></textarea>

        <label for="duration">Duración (días):</label>
        <input type="number" name="duration" id="duration" min="1" required>

        <label for="objectives">Objetivos del desafío:</label>
        <textarea name="objectives" id="objectives" rows="3"></textarea>

        <input type="submit" value="Crear Desafío" class="btn-primary">
    </form>
</div>

<?php include '../includes/footer.php'; ?>
