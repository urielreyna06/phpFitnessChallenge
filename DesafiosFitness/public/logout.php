<?php
session_start();
session_unset();
session_destroy();

// Borrar cookies
setcookie("last_login", "", time() - 3600, "/");
setcookie("tema", "", time() - 3600, "/");
setcookie("fuente", "", time() - 3600, "/");

header("Location: login.php");
exit;
