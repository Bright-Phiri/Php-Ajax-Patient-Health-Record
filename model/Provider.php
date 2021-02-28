<?php
class Provider extends DB{
    private $username;
    private $email;
    private $password;

    public function __construct(){
        parent::__construct();
    }

    public function set_provider($username, $email, $password){
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getTotalNumberOfProviders(){
        $query = "SELECT * FROM providers";
        $result = self::$conn->query($query);
        return $result->num_rows;
    }

    public function login($email,$password){
        $response = array();
        $query = "SELECT * FROM providers WHERE email = ? AND password = ?";
        $pre = self::$conn->prepare($query);
        if($pre->bind_param("ss", $email, $password)){
        $pre->execute();
        $result = $pre->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['isLoggedIn'] = true;
            }
            $response[0] = "status";
            $response[1] = "success";
            echo json_encode($response);
        } else {
            $response[0] = "Error";
            $response[1] = "Email Address or Password is incorrect";
            $response[2] = "error";
            $response[3] = "Ok";
            echo json_encode($response);
        }
        }
    }
    
    public function add_provider($provider){
        $query = "INSERT INTO providers (username,email,password) VALUES (?,?,?)";
        $pre = self::$conn->prepare($query);
        $pre->bind_param("sss", $this->username, $this->email,$this->password);
        $result = $pre->execute();
        if (!$result){
            return false;
        }
        return true;
    }

    public function checkIfEmailExists($email){
        $query = "SELECT * FROM providers WHERE email = ?";
        $pre = self::$conn->prepare($query);
        $pre->bind_param("s", $email);
        $pre->execute();
        $result = $pre->get_result(); 
        if ($result->num_rows > 0) {
           return true;
        }
        return false;
    }

    public function checkIfUsernameExists($username){
        $query = "SELECT * FROM providers WHERE username = ?";
        $pre = self::$conn->prepare($query);
        $pre->bind_param("s", $username);
        $pre->execute();
        $result = $pre->get_result(); 
        if ($result->num_rows > 0) {
           return true;
        }
        return false;
    }

    public function viewUsers(){
      global $conn;
      $html = "";
      $html = '<table class="table table-sm table-bordered table-hover" id="usertable">
      <thead class="thead-light">
        <th>ID</th>
        <th>Username</th>
        <th>Email Adress</th>
        <th>Date Registered</th>
    </thead>';
    $sql = "SELECT * FROM providers";
    $result = self::$conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>
            <td>' . $row['provider_id'] . '</td>
            <td>' . $row['username'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['registered_date']. '</td>
        </tr>';
        }
    } else {
        $html .= ' <tr><td colspan="4" align="center">No data found</td></tr>';
    }
    $html .= '</table> ';

    echo json_encode(['status' => 'success', 'content' => $html]);
   }
}
?>