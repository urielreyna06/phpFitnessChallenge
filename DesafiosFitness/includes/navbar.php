<?php
require_once dirname(__DIR__) . "/config/config.php";
$tema = $_COOKIE['tema'] ?? 'claro';
?>

<nav class="main-navbar <?= $tema === 'oscuro' ? 'dark-mode' : '' ?>">
  <div class="logo">
    <a href="<?= BASE_URL ?>public/index.php">
      <img src="<?= BASE_URL ?>assets/img/Logo.png" alt="Logo Desafíos Fitness" class="logo-img">
      Desafíos Fitness
    </a>
  </div>
  <ul class="nav-links">
    <li><a href="<?= BASE_URL ?>public/index.php">Inicio</a></li>
    <li><a href="<?= BASE_URL ?>public/challenges.php">Desafíos</a></li>
    <li><a href="<?= BASE_URL ?>public/progress.php">Progreso</a></li>
    <li><a href="<?= BASE_URL ?>public/estadisticas.php">Estadísticas</a></li>
    <li><a href="<?= BASE_URL ?>public/preferences.php">Preferencias</a></li>
    <li><a href="<?= BASE_URL ?>public/logout.php">Cerrar sesión</a></li>
  </ul>
</nav>
