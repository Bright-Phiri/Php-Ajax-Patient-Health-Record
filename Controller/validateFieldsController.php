<?php
require_once('../model/mysqli.php');
require_once('../model/Provider.php');
require_once('../resources/functions.php');
$provider = new Provider();
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    if ($provider->checkIfUsernameExists($username)) {
        echo "true";
    }
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if ($provider->checkIfEmailExists($email)) {
        echo "true";
    }
}
