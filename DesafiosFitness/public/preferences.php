<?php
require_once '../config/config.php';
require_once DB_PATH . '/db.php';
require_once LIB_PATH . '/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tema = $_POST['tema'] ?? 'claro';
    $fuente = $_POST['fuente'] ?? 'sans-serif';

    setcookie("tema", $tema, time() + (86400 * 365), "/");
    setcookie("fuente", $fuente, time() + (86400 * 365), "/");

    $mensaje = "✅ Preferencias guardadas correctamente.";
}
?>

<?php include INCLUDES_PATH . '/header.php'; ?>

<div class="card fade-in" style="max-width: 600px; margin: 40px auto;">
    <h2>Preferencias del Usuario</h2>
    <p style="text-align:center;">Personaliza tu experiencia visual.</p>

    <?php if ($mensaje): ?>
        <div class="message success"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="tema">Tema:</label>
        <select name="tema" id="tema" required>
            <option value="claro" <?= ($_COOKIE['tema'] ?? '') == 'claro' ? 'selected' : '' ?>>Claro</option>
            <option value="oscuro" <?= ($_COOKIE['tema'] ?? '') == 'oscuro' ? 'selected' : '' ?>>Oscuro</option>
        </select>

        <label for="fuente">Fuente:</label>
        <select name="fuente" id="fuente" required>
            <option value="Arial" <?= ($_COOKIE['fuente'] ?? '') == 'Arial' ? 'selected' : '' ?>>Arial</option>
            <option value="Verdana" <?= ($_COOKIE['fuente'] ?? '') == 'Verdana' ? 'selected' : '' ?>>Verdana</option>
            <option value="Tahoma" <?= ($_COOKIE['fuente'] ?? '') == 'Tahoma' ? 'selected' : '' ?>>Tahoma</option>
            <option value="Courier New" <?= ($_COOKIE['fuente'] ?? '') == 'Courier New' ? 'selected' : '' ?>>Courier New</option>
        </select>

        <input type="submit" value="Guardar preferencias">
    </form>
</div>

<?php include INCLUDES_PATH . '/footer.php'; ?>
