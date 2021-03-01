<?php
function auth_login() {
    session_start();
    if (!isset($_SESSION['email']) && !isset($_SESSION['isLoggedIn'])) {
        header('Location:login.php');
    }
}

function auth_login1() {
    session_start();
    if (!isset($_SESSION['email']) && !isset($_SESSION['isLoggedIn'])) {
        header('Location:view/login.php');
    } else {
        header('Location:view/index.php');
    }
}

function logout() {
    session_start();
    if (isset($_POST['logout-btn'])) {
        session_destroy();
        header('Location:../view/index.php');
    }
}

function checkData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
