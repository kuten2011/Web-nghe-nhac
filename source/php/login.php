<?php
session_start();
// Validate input data
if (!isset($_POST['user']) || !isset($_POST['pass'])) {
  die("Missing input data");
}
$usn = $_POST['user'];
$pas = $_POST['pass'];
$regexUsername = "/^[a-zA-Z0-9]{8,}$/";
$regexPw = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
// $regexPw = "/.*/";

if ($usn =="admin" && $pas == "123456" || preg_match($regexUsername, $usn)) {
    require_once("db.php");
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? and password = ?");
    $stmt->bind_param("ss", $usn, $pas);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $_SESSION['user_id']=$user_id;
        // Send user ID back to client
        $response = array(  'success'=> true ,
                            "result" => "success",
                            "user_id" => $row['user_id'],
                            "username" => $row['username'],
                            "admin_rights" => $row['admin_rights']
                        );
    } else {
        // Login failed, send error message back to client
        $response = array('success'=>false, "result" => "Invalid username or password");
    }

} else {
    $response = array("success"=>false, "result" => "Invalid username or password");
    // echo json_encode("false")
}
echo json_encode($response);
session_write_close();
?>
