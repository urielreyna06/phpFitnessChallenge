<?php
session_start();
require_once '../config/config.php';
require_once DB_PATH . '/db.php';
require_once LIB_PATH . '/functions.php';

$error = null;
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_completo = trim($_POST['fullname']);
    $email           = trim($_POST['email']);
    $celular         = trim($_POST['phone']);
    $nacimiento      = $_POST['birthdate'];
    $sexo            = $_POST['gender'];
    $username        = trim($_POST['username']);
    $password        = $_POST['password'];

    if (empty($nombre_completo) || empty($email) || empty($username) || empty($password)) {
        $error = "Todos los campos obligatorios deben estar llenos.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Ya existe un usuario con ese nombre o correo.";
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (nombre_completo, email, celular, nacimiento, sexo, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nombre_completo, $email, $celular, $nacimiento, $sexo, $username, $hashed);

            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['username'] = $username;
                setcookie("last_login", date("Y-m-d H:i:s"), time() + 86400 * 30, "/");
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Ocurrió un error al registrar. Inténtalo de nuevo.";
            }
        }
    }
}
?>

<?php include_once '../includes/header.php'; ?>
<?php include_once '../templates/register_form.php'; ?>
<?php include_once '../includes/footer.php'; ?>
