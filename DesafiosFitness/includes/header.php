<?php
require_once __DIR__ . '/../config/config.php';

$tema = $_COOKIE['tema'] ?? 'claro';
$fuente = $_COOKIE['fuente'] ?? 'Arial, sans-serif';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Desafíos Fitness</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Estilos -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap">

  <!-- JS -->
  <script src="<?= BASE_URL ?>assets/js/app.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Personalización dinámica -->
  <style>
    body {
      background-color: <?= $tema === 'oscuro' ? '#121212' : '#faf5ff' ?>;
      color: <?= $tema === 'oscuro' ? '#ffffff' : '#333333' ?>;
      font-family: <?= $fuente ?>;
    }
  </style>
</head>
<body class="<?= $tema === 'oscuro' ? 'dark-mode' : '' ?>">

  <!-- NAVBAR -->
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

  <!-- BANNER -->
  <section class="banner">
    <img src="<?= BASE_URL ?>assets/img/head_banner.png" alt="Banner Fitness" class="banner-img">
  </section>
