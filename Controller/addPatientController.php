<?php
require_once('../model/mysqli.php');
require_once('../model/Patient.php');
require_once('../resources/functions.php');
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$district = $_POST['district'];
$village = $_POST['village'];
$current_address = $district . ", " . $village;
$occupation = $_POST['occupation'];
$response = array();
$firstName = checkData($firstName);
$lastName = checkData($lastName);
$gender = checkData($gender);
$dob = checkData($dob);
$current_address = checkData($current_address);
$occupation = checkData($occupation);
$patient = new Patient();
$patient->set_patient($firstName, $lastName, $gender, $dob, $current_address, $occupation);
if ($patient->add_patient($patient)) {
    $response[0] = "Information";
    $response[1] = "Patient successfully added";
    $response[2] = "info";
    $response[3] = "Ok";
    echo json_encode($response);
} else {
    $response[0] = "Error";
    $response[1] = "Failed to add the patient";
    $response[2] = "error";
    $response[3] = "Ok";
    echo json_encode($response);
}