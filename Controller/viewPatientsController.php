<?php
require_once('../model/mysqli.php');
require_once('../model/Patient.php');
$patient = new Patient();
$patient->viewPatients();
?>