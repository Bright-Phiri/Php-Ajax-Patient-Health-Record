<?php
require_once('../resources/functions.php');
require_once('../model/mysqli.php');
require_once('../model/Health_record.php');
$weight = $_POST['weight'];
$height = $_POST['height'];
$temp_reading = $_POST['temp_reading'];
$diagnosis = explode('|', $_POST['diagnosis']);
$code = $diagnosis[0];
$code_description = $diagnosis[1];
$patient_id = $_POST['patient-id'];
$provider_username = $_POST['username'];
$response = array();
$h_record = new Health_Record();
$h_record->set_health_record($patient_id, $weight, $height, $temp_reading, $code, $code_description, $provider_username);
if ($h_record->add_patient_health_record($h_record)) {
    $response[0] = "Information";
    $response[1] = "Patient's health record successfully added";
    $response[2] = "info";
    $response[3] = "Ok";
    echo json_encode($response);
} else {
    $response[0] = "Error";
    $response[1] = "Failed to add the record";
    $response[2] = "error";
    $response[3] = "Ok";
    echo json_encode($response);
}
?>