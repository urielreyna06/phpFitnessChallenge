<?php
require_once '../config/config.php';
require_once DB_PATH . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';
$error = '';

// Manejar creación de desafío
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $duration = intval($_POST['duration']);
    $objectives = trim($_POST['objectives']);

    if (empty($title) || empty($description) || $duration <= 0) {
        $error = "⚠️ Todos los campos obligatorios deben estar completos.";
    } else {
        $stmt = $conn->prepare("INSERT INTO challenges (title, description, duration, objectives) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $title, $description, $duration, $objectives);
        if ($stmt->execute()) {
            $mensaje = "✅ Desafío creado correctamente.";
        } else {
            $error = "❌ Ocurrió un error al crear el desafío.";
        }
    }
}

// Obtener desafíos predefinidos
$predefinidos = $conn->query("SELECT * FROM challenges ORDER BY id DESC");
?>

<?php include_once INCLUDES_PATH . '/header.php'; ?>

<div class="challenge-container fade-in">
    <!-- Formulario para crear desafío -->
    <div class="challenge-form-section">
        <h2 style="margin-bottom: 20px;">Crear Nuevo Desafío</h2>

        <?php if ($mensaje): ?>
            <div class="message success"><?= htmlspecialchars($mensaje) ?></div>
        <?php elseif ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="fade-in">
            <label for="title">Título:</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Descripción:</label>
            <textarea name="description" id="description" rows="2" required></textarea>

            <label for="duration">Duración (días):</label>
            <input type="number" name="duration" id="duration" required>

            <label for="objectives">Objetivos:</label>
            <textarea name="objectives" id="objectives" rows="2"></textarea>

            <input type="submit" value="Crear Desafío">
        </form>
    </div>

    <!-- Lista de desafíos disponibles -->
    <div class="challenge-list-section">
        <h2 style="margin-bottom: 20px;">Desafíos Predefinidos</h2>
        <div class="challenge-grid">
            <?php while ($desafio = $predefinidos->fetch_assoc()): ?>
                <div class="challenge-card">
                    <h3><?= htmlspecialchars($desafio['title']) ?></h3>
                    <p><strong>Duración:</strong> <?= $desafio['duration'] ?> días</p>
                    <p><strong>Descripción:</strong> <?= htmlspecialchars($desafio['description']) ?></p>
                    <p><strong>Objetivos:</strong> <?= htmlspecialchars($desafio['objectives']) ?></p>
                    <form method="POST" action="join_challenge.php">
                        <input type="hidden" name="challenge_id" value="<?= $desafio['id'] ?>">
                        <button type="submit">Unirme al desafío</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php include_once INCLUDES_PATH . '/footer.php'; ?>
