<?php
session_start();
require_once '../config/config.php';
require_once DB_PATH . '/db.php';
require_once LIB_PATH . '/functions.php';

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            setcookie("last_login", date("Y-m-d H:i:s"), time() + 86400 * 30, "/");
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<?php include_once '../includes/header.php'; ?>

<div class="card fade-in" style="max-width: 500px; margin: 40px auto;">
    <h2>Iniciar sesión</h2>

    <?php if ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Ingresar" class="btn-primary">

        <div style="text-align: center; margin-top: 10px;">
            ¿No tienes cuenta? <a href="register.php">Regístrate</a>
        </div>
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>
