<?php
include '../config/config.php';
include '../db/db.php';
include '../lib/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Obtener todos los desafíos
$desafios = $conn->query("
    SELECT c.id, c.title, c.description
    FROM challenges c
    WHERE c.id NOT IN (
        SELECT challenge_id FROM user_challenges WHERE user_id = $user_id
    )
");
if (usuarioInscritoEnDesafio($conn, $_SESSION['user_id'], $challenge_id)) {
    echo "Ya estás inscrito en este desafío.";
}

// Procesar la inscripción
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $challenge_id = $_POST['challenge_id'];
    $start_date = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO user_challenges (user_id, challenge_id, start_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $challenge_id, $start_date);
    $stmt->execute();

    $mensaje = "✅ Te has unido al desafío correctamente.";
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div class="card">
    <h2>Unirse a un desafío</h2>

    <?php if (!empty($mensaje)) echo "<p style='color:green;'>$mensaje</p>"; ?>

    <?php if ($desafios->num_rows == 0): ?>
        <p>Ya estás inscrito en todos los desafíos disponibles 🎉</p>
    <?php else: ?>
        <form method="POST" action="">
            <label for="challenge_id">Selecciona un desafío:</label><br>
            <select name="challenge_id" required>
                <?php while ($row = $desafios->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?> - <?= htmlspecialchars($row['description']) ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <input type="submit" value="Unirme al desafío">
        </form>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
