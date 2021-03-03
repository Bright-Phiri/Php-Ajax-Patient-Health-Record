<?php
require_once('../model/mysqli.php');
require_once('../model/Provider.php');
require_once('../resources/functions.php');
$provider = new Provider();
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$response = array();
$password = sha1($password);
$provider->set_provider($username, $email, $password);
if ($provider->add_provider($provider)) {
    $response[0] = "Success";
    $response[1] = "Account successfully created";
    $response[2] = "success";
    $response[3] = "Ok";
    echo json_encode($response);
} else {
    $response[0] = "Error";
    $response[1] = "Failed to create account";
    $response[2] = "error";
    $response[3] = "Ok";
    echo json_encode($response);
}
