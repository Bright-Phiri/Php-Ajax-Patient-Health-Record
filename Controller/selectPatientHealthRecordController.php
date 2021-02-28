<?php
require_once('../model/mysqli.php');
require_once('../model/Health_record.php');
$patient_id = $_POST['id'];
$h_record = new Health_Record();
$h_record->getMedicalRecords($patient_id);
?>