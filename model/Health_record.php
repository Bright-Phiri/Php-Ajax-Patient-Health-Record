<?php
class Health_Record extends DB {

    private $patient_id;
    private $weight;
    private $height;
    private $temp_reading;
    private $diagnosis;
    private $description;
    private $provider_name;

    public function __construct() {
        parent::__construct();
    }

    public function set_health_record($patient_id, $weight, $height, $temp_reading, $diagnosis, $description, $provider_name) {
        $this->patient_id = $patient_id;
        $this->weight = $weight;
        $this->height = $height;
        $this->temp_reading = $temp_reading;
        $this->diagnosis = $diagnosis;
        $this->description = $description;
        $this->provider_name = $provider_name;
    }

    public function getPatientId() {
        return $this->patient_id;
    }

    public function getweight() {
        return $this->weight;
    }

    public function getheight() {
        return $this->height;
    }

    public function gettemp_reading() {
        return $this->temp_reading;
    }

    public function getdiagnosis() {
        return $this->diagnosis;
    }

    public function add_patient_health_record($h_record) {
        $query = "INSERT INTO health_records (patient_id,weight ,height ,temp_reading ,code,code_description,provider_username) VALUES(?,?,?,?,?,?,?)";
        $pre = self::$conn->prepare($query);
        if ($pre->bind_param("idddsss", $this->patient_id, $this->weight, $this->height, $this->temp_reading, $this->diagnosis, $this->description, $this->provider_name)) {
            $result = $pre->execute();
            if ($result) {
                return true;
            }
            return false;
        }
    }

    public function getMedicalRecords($id) {
        $query = "SELECT * FROM health_records WHERE patient_id = $id ORDER BY visit_date DESC";
        $html = '<ul class="timeline">';
        $result = self::$conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $visit_date = $row['visit_date'];
                $html .= '<li>
               <a class="text-primary">Vital Signs</a>
               <a class="float-right text-primary">' . date("D, d M Y H:i A", strtotime($visit_date)) . '</a>
               <table class="table table-bordered mt-2">
               <thead class="thead-light">
                  <tr>
                    <th scope="col">Weight(Kgs)</th>
                    <th scope="col">Height(M)</th>
                    <th scope="col">Temperature Reading<span>&#8451;</span></th>
                  </tr>
                </thead>
                <tbody>
                   <tr>
                     <td>' . $row['weight'] . '</td>
                     <td>' . $row['height'] . '</td>
                     <td>' . $row['temp_reading'] . '</td>
                   </tr>
                <tbody>
               </table>
                <div class="card mt-2">
                    <div class="card-header bg-light">
                        <h6>Diagnosis used</h6>
                    </div>
                    <div class="card-body">
                        <ul>
                           <li>' . $row['code_description'] . '</li>
                           <a class="btn btn-primary mt-3" href="https://www.icd10data.com/ICD10CM/Codes/' . $row['code'] . '" target="_blank">View Diagnosis</a>
                        </ul>
                    </div>
                </div>
           </li>';
            }
        } else {
            $html .= '<li><center>No data recorded for this patient</center></li>';
        }
        $html .= '<ul>';
        echo json_encode(['status' => 'success', 'content' => $html]);
    }

}
?>