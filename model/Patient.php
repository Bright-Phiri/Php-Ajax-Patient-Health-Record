<?php
class Patient extends DB {

  private $id;
  private $first_name;
  private $last_name;
  private $gender;
  private $date_of_birth;
  private $current_address;
  private $occupation;

  public function __construct() {
      parent::__construct();
  }

  public function set_patient($first_name, $last_name, $gender, $date_of_birth, $current_address, $occupation) {
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->gender = $gender;
      $this->date_of_birth = $date_of_birth;
      $this->current_address = $current_address;
      $this->occupation = $occupation;
  }

  public function getId() {
      return $this->id;
  }

  public function getFirstName() {
      return $this->first_name;
  }

  public function getLastName() {
      return $this->last_name;
  }

  public function getGender() {
      return $this->gender;
  }

  public function getDateOfBirth() {
      return $this->date_of_birth;
  }

  public function getCurrentAddress() {
      return $this->current_address;
  }

  public function getOccupation() {
      return $this->occupation;
  }

  public function add_patient($patient) {
      $query = "INSERT INTO patients (first_name,last_name,gender ,date_of_birth,current_address,occupation) VALUES(?,?,?,?,?,?)";
      $pre = self::$conn->prepare($query);
      if ($pre->bind_param("ssssss", $this->first_name, $this->last_name, $this->gender, $this->date_of_birth, $this->current_address, $this->occupation)) {
          $result = $pre->execute();
          if ($result) {
              return true;
          }
          return false;
      }
  }

  public function getTotalNumberOfHealthRecords() {
      $query = "SELECT * FROM health_records";
      $result = self::$conn->query($query);
      return $result->num_rows;
  }

  public function getTotalNumberOfPatients() {
      $query = "SELECT * FROM patients";
      $result = self::$conn->query($query);
      return $result->num_rows;
  }

  public function viewPatients() {
      $html = "";
      $html = '<table class="table table-sm table-bordered table-hover" id="patientstable">
         <thead class="thead-light">
         <th>Patient ID</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Gender</th>
         <th>Date of birth</th>
         <th>Current Address</th>
         <th>Occupation</th>
         <th>Medical Record</th>
      </thead>';
      $sql = "SELECT * FROM patients";
      $result = self::$conn->query($sql);
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $html .= '<tr>
          <td>' . $row['patient_id'] . '</td>
          <td>' . $row['first_name'] . '</td>
          <td>' . $row['last_name'] . '</td>
          <td>' . $row['gender'] . '</td>
          <td>' . $row['date_of_birth'] . '</td>
          <td>' . $row['current_address'] . '</td>
          <td>' . $row['occupation'] . '</td>
          <td colspan="2">
          <Button class="btn btn-primary" id="add-medical-record" data-id="' . $row['patient_id'] . '"><i class="fa fa-plus-circle"></i></Button>
          <Button class="btn btn-secondary" id="view-medical-record" data-id1="' . $row['patient_id'] . '"><i class="fa fa-eye"></i></Button>
          </td>
      </tr>';
          }
      } else {
          $html .= ' <tr><td colspan="8" align="center">No records found</td></tr>';
      }
      $html .= '</table> ';
      echo json_encode(['status' => 'success', 'content' => $html]);
  }

}
