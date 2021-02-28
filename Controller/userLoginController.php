<?php
session_start();
require_once('../model/mysqli.php');
require_once('../model/Provider.php');
    $email = $_POST['umail'];
    $password = $_POST['upass']; 
    $password = sha1($password);
    $provider = new Provider();
    $provider->login($email, $password);
?>