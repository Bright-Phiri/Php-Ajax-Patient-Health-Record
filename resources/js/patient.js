$(document).ready(function() {
    addPatient();
    viewPatients();
    selectRecord()
    viewMedicalRecord();
    addPatientHealthRecord();
})

function showAlert1(title, message, iconName, buttonText) {
    swal({
        title: title,
        text: message,
        icon: iconName,
        button: buttonText,
    }).then(function() {
        window.location.href = 'index.php';
    })

}

function showAlert(title, message, iconName, buttonText) {
    swal({
        title: title,
        text: message,
        icon: iconName,
        button: buttonText,
    })
}

function addPatient() {
    $("#add-user-btn").click(function() {
        var firstName = $("#firstname").val();
        var lastName = $("#lastname").val();
        var gender = $("#gender").val();
        var dateOfBirth = $("#birthdate").val();
        var district = $("#district").val();
        var village = $("#village").val();
        var occupation = $("#occupation").val();
        var dob = new Date(dateOfBirth);
        var today = new Date();
        var date = new Date(today.toLocaleDateString("en-US"));
        if (dateOfBirth == '' || village == '' || firstName == '' || lastName == '' || gender == '' || district == '' || occupation == '') {
            showAlert("Fields Validation", "Please enter in all fields", "warning", "Ok");
        } else {
            var pattern = /^[a-zA-Z/' ]+$/;
            if (!firstName.match(pattern)) {
                showAlert("Fields Validation", "First Name is invalid", "warning", "Ok");
            } else if (!lastName.match(pattern)) {
                showAlert("Fields Validation", "Last Name is invalid", "warning", "Ok");
            } else if (!district.match(pattern)) {
                showAlert("Fields Validation", "District is invalid", "warning", "Ok");
            } else if (!village.match(pattern)) {
                showAlert("Fields Validation", "Village is invalid", "warning", "Ok");
            } else if (dob > date && dob.getDay() != date.getDay()) {
                showAlert("Fields Validation", "Date is invalid", "warning", "Ok");
            } else {
                var formData = $("#patient-form").serialize();
                $.ajax({
                    url: '../Controller/addPatientController.php',
                    method: 'post',
                    dataType: 'JSON',
                    data: formData,
                    success: function(response) {
                        showAlert(response[0], response[1], response[2], response[3]);
                        $("form").trigger("reset");
                    }
                })
            }
        }

    })
}

function addPatientHealthRecord() {
    $("#health-record-btn").click(function() {
        var weight = $("#weight").val();
        var height = $("#height").val();
        var temp_reading = $("#temp_reading").val();
        var diagnosis = $("#diagnosis").val();
        var patient_id = $("#patient-id").val();
        var username = $("#username").val();
        if (weight == '' || height == '' || temp_reading == '' || diagnosis == '') {
            showAlert("Fields Validation", "Please enter in all fields", "warning", "Ok");
        } else {
            var formData = $("#health-records-form").serialize();
            $.ajax({
                url: '../Controller/addPatientHealthRecordController.php',
                method: 'post',
                dataType: 'JSON',
                data: formData,
                success: function(response) {
                    showAlert(response[0], response[1], response[2], response[3]);
                    $("form").trigger("reset");
                    $("#medicalRecord").modal("hide");
                }
            })
        }
    })
}

function viewPatients() {
    $.ajax({
        url: "../Controller/viewPatientsController.php",
        method: "post",
        success: function(data) {
            data = $.parseJSON(data);
            $("#patients-table").html(data.content);
            $('#patientstable').DataTable();
        },
    });
}

function selectRecord() {
    $(document).on("click", "#add-medical-record", function() {
        var patient_id = $(this).attr("data-id");
        $("#patient-id").val(patient_id);
        $("#medicalRecord").modal("show");
    });
}

function viewMedicalRecord() {
    $(document).on("click", "#view-medical-record", function() {
        var patient_id = $(this).attr("data-id1");
        $("#id").val(patient_id);
        $.ajax({
            url: "../Controller/selectPatientHealthRecordController.php",
            method: "post",
            data: {
                id: patient_id
            },
            success: function(data) {
                data = $.parseJSON(data);
                $("#patient_data").html(data.content);
                $("#viewMedicalRecord").modal("show");
            },
        });

    });
}