<?php
require_once '../config/config.php';
require_once DB_PATH . '/db.php';
require_once LIB_PATH . '/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Obtener nombre del usuario
$stmt = $conn->prepare("SELECT nombre_completo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nombre_completo);
$stmt->fetch();
$stmt->close();

// Obtener desafíos del usuario
$desafios = [];
$sql = "SELECT c.title, c.description, uc.progreso, uc.start_date
        FROM user_challenges uc
        JOIN challenges c ON uc.challenge_id = c.id
        WHERE uc.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $desafios[] = $row;
}
$stmt->close();
?>

<?php include_once INCLUDES_PATH . '/header.php'; ?>

<div class="dashboard-container fade-in">
    <div>
        <div class="dashboard-welcome">
            <h2>Bienvenido/a, <?= htmlspecialchars($nombre_completo) ?> 👋</h2>
            <p>¡Nos alegra verte de nuevo! Aquí puedes revisar tu progreso y gestionar tus desafíos.</p>
            <a href="progress.php"><button class="btn-primary" style="margin-top: 10px;">Registrar nueva actividad</button></a>
        </div>

        <div class="card">
            <h3>Desafíos activos</h3>
            <?php if (count($desafios) > 0): ?>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Progreso</th>
                        <th>Inicio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($desafios as $d): ?>
                        <tr>
                            <td><?= htmlspecialchars($d['title']) ?></td>
                            <td><?= htmlspecialchars($d['description']) ?></td>
                            <td><?= $d['progreso'] ?>%</td>
                            <td><?= $d['start_date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p style="text-align: center;">Aún no tienes desafíos asignados.</p>
            <?php endif; ?>
        </div>
    </div>

    <div>
        <div class="card">
            <h3 style="display: flex; justify-content: space-between; align-items: center;">
                <span>Resumen visual</span>
                <a href="estadisticas.php" style="font-size: 14px; color: var(--deep-purple);">Ver estadísticas completas →</a>
            </h3>
            <canvas id="graficaProgreso" style="max-width: 100%; margin-top: 20px;"></canvas>
        </div>

        <div class="stats-grid">
            <div class="stat-box">
                <div>Desafíos</div>
                <strong><?= count($desafios) ?></strong>
            </div>
            <div class="stat-box">
                <div>Progreso promedio</div>
                <strong>
                    <?php
                        $total = array_sum(array_column($desafios, 'progreso'));
                        $avg = count($desafios) > 0 ? round($total / count($desafios), 1) : 0;
                        echo $avg . '%';
                    ?>
                </strong>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficaProgreso').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($desafios, 'title')) ?>,
            datasets: [{
                label: 'Progreso (%)',
                data: <?= json_encode(array_column($desafios, 'progreso')) ?>,
                backgroundColor: '#ba68c8',
                borderRadius: 8
            }]
        },
        options: {
            animation: {
                duration: 800,
                easing: 'easeOutQuart'
            },
            scales: {
                y: { beginAtZero: true, max: 100 }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

<?php include_once INCLUDES_PATH . '/footer.php'; ?>
