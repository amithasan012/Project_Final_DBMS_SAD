<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['user']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        header("Location: /hos2/auth/login.php");
        exit();
    }
}

function redirect_if_not_admin() {
    if (!is_admin()) {
        header("Location: /hos2/index.php");
        exit();
    }
}
?>