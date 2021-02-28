<?php
require_once('../model/mysqli.php');
require_once('../model/Provider.php');
$provider = new Provider();
$provider->viewUsers();
?>