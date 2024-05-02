<?php
session_start(); // Zugriff auf die bestehende Session

// Session-Variablen löschen
$_SESSION = array();

// Session löschen
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy(); // Zerstören der Session
header("Location: newindex.php"); // Umleitung zur Login-Seite
exit;
?>
