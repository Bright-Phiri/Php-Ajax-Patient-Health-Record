<?php
require_once('../model/mysqli.php');
require_once('../model/Provider.php');
require_once('../resources/functions.php');
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];
$response = array();
$provider = new Provider();
if ($provider->checkIfUsernameExists($username)){
    $response[0] = "Warning";
    $response[1] = "This username is already taken";
    $response[2] = "warning";
    $response[3] = "Ok";
    echo json_encode($response);
} else if ($provider->checkIfEmailExists($email)){
    $response[0] = "Warning";
    $response[1] = "This email address is already connected to an account";
    $response[2] = "warning";
    $response[3] = "Ok";
    echo json_encode($response);
} else{
    $password = sha1($password);
    $provider->set_provider($username,$email,$password);
    if ($provider->add_provider($provider)){
        $response[0] = "Success";
        $response[1] = "Account successfully created";
        $response[2] = "success";
        $response[3] = "Ok";
        echo json_encode($response);
    } else{
        $response[0] = "Error";
        $response[1] = "Failed to create account";
        $response[2] = "error";
        $response[3] = "Ok";
        echo json_encode($response);
    }
}


?>