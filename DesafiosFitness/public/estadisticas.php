<?php
require_once '../config/config.php';
require_once DB_PATH . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT c.title, uc.progreso, uc.start_date 
                        FROM user_challenges uc
                        JOIN challenges c ON uc.challenge_id = c.id
                        WHERE uc.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$desafios = [];
while ($row = $result->fetch_assoc()) {
    $desafios[] = $row;
}
$stmt->close();

$fechas = ["2025-07-01", "2025-07-02", "2025-07-03", "2025-07-04", "2025-07-05"];
$actividades = [10, 20, 15, 25, 30];
?>

<?php include INCLUDES_PATH . '/header.php'; ?>

<div class="card fade-in">
    <h2>📊 Estadísticas Completas de tus Desafíos</h2>
    <p style="text-align:center;">Explora tu rendimiento y progreso acumulado.</p>

    <div class="stats-section">
        <div class="stat-card">
            <h4>Progreso por Desafío</h4>
            <canvas id="progresoPorDesafio"></canvas>
        </div>

        <div class="stat-card">
            <h4>Actividades por Día</h4>
            <canvas id="actividadDiaria"></canvas>
        </div>

        <div class="stat-card">
            <h4>Distribución de Progreso</h4>
            <canvas id="graficaPastel"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const desafios = <?= json_encode(array_column($desafios, 'title')) ?>;
    const progresos = <?= json_encode(array_column($desafios, 'progreso')) ?>;
    const fechas = <?= json_encode($fechas) ?>;
    const actividades = <?= json_encode($actividades) ?>;

    const colorPrimario = getComputedStyle(document.body).getPropertyValue('--light-purple').trim() || '#ba68c8';

    new Chart(document.getElementById("progresoPorDesafio"), {
        type: 'bar',
        data: {
            labels: desafios,
            datasets: [{
                label: 'Progreso (%)',
                data: progresos,
                backgroundColor: colorPrimario,
                borderRadius: 10
            }]
        },
        options: {
            scales: { y: { beginAtZero: true, max: 100 } },
            plugins: { legend: { display: false } }
        }
    });

    new Chart(document.getElementById("actividadDiaria"), {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: 'Minutos Activos',
                data: actividades,
                fill: true,
                borderColor: '#9c27b0',
                backgroundColor: 'rgba(156, 39, 176, 0.2)',
                tension: 0.3
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: true } }
        }
    });

    new Chart(document.getElementById("graficaPastel"), {
        type: 'doughnut',
        data: {
            labels: desafios,
            datasets: [{
                label: 'Distribución',
                data: progresos,
                backgroundColor: [
                    '#ba68c8', '#ce93d8', '#ab47bc', '#8e24aa', '#4a148c'
                ]
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

<style>
.stats-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 32px;
    padding: 32px;
}
.stat-card {
    background-color: var(--card-light);
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
body.dark-mode .stat-card {
    background-color: var(--card-dark);
}
</style>

<?php include INCLUDES_PATH . '/footer.php'; ?>
