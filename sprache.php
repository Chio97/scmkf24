<?php
    session_start();
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = 'de';
    }
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
        $_SESSION['lang'] = $_GET['lang'];
    }

    $lang = require 'languages/' . $_SESSION['lang'] . '.php';

    if (!isset($_SESSION['benutzername'])) {
        header("Location: newindex.php");
        exit;
    }
    ?>