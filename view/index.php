<?php
require_once('../resources/functions.php');
auth_login();
include('header.php');
include('sidebar.php');
?>

<!-- Page Content-->
<div class="main-content">
    <div class="main-content-header">
        <div class="row">
            <di class="col-12 justify-content-between d-flex">
                <h5> <i class="fa fa-home ml-2" style="color:#007BFF"></i> Dashboard</h5>
                <?php
                if (isset($_SESSION['username']) && $_SESSION['username'] != NULL) {
                ?>
                    <h5>
                        <?php echo $_SESSION['username'] ?><i class="fa fa-user-circle ml-2"></i>
                    </h5>
                <?php
                }
                ?>
            </di>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <div class="row">
                            <div class="col-2"><i class="fa fa-users fa-3x"></i></div>
                            <div class="col">
                                <h6 class="text-center">All Patients</h6>
                                <h5 class="text-center text-white">
                                    <?php
                                    require_once('../model/mysqli.php');
                                    require_once('../model/Patient.php');
                                    $patient = new Patient();
                                    echo $patient->getTotalNumberOfPatients();
                                    ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card footer p-1"><a href="add_patient.php">Create patient</a></div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                <div class="card mb-2">
                    <div class="card-header bg-success text-white">
                        <div class="row">
                            <div class="col-2"><i class="fa fa-users fa-3x"></i></div>
                            <div class="col">
                                <h6 class="text-center">Patient's health records</h6>
                                <h5 class="text-center text-white">
                                    <?php
                                    require_once('../model/mysqli.php');
                                    require_once('../model/Patient.php');
                                    $patient = new Patient();
                                    echo $patient->getTotalNumberOfHealthRecords();
                                    ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card footer p-1"><a href="view_patients.php">View patients</a></div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                <div class="card mb-2">
                    <div class="card-header bg-warning text-white">
                        <div class="row">
                            <div class="col-2"><i class="fa fa-users fa-3x"></i></div>
                            <div class="col">
                                <h6 class="text-center">All Users / Providers</h6>
                                <h5 class="text-center text-white">
                                    <?php
                                    require_once('../model/mysqli.php');
                                    require_once('../model/Provider.php');
                                    $provider = new Provider();
                                    echo $provider->getTotalNumberOfProviders();
                                    ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card footer p-1"><a href="view_users.php">View users / providers</a></div>
                </div>
            </div>

        </div>
    </div>
    <!-- End of Page Content-->
    <?php include('footer.php'); ?>