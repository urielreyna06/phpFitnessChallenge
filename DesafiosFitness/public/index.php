<?php
require_once '../config/config.php';

if (!isset($_SESSION)) session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
} else {
    header("Location: login.php");
}
exit;
