<?php
session_start();
require_once("../php/user_class.php");
header('Content-Type: application/json; charset=utf-8');
$users = new UserController; // $users này chứa thông tin user và các method xử lý dữ liệu
// $data = array('success' => true, "data"=> $users->get_list());
if ($_SERVER["REQUEST_METHOD"] == "GET") { //lấy hết tất cả user
    //...
    //trả về json dssv
    if (!isset($_GET['user_id'])) {
        $data = array('success' => true, "data" => $users->get_list());
        echo json_encode($data);
        die();
    } else {
        $data = array('success' => true, "data" => $users->get_one($_GET['user_id']));
        echo json_encode($data);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //thêm user
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    if ($data->action === "signup") {
        $result = $users->add_one($data);
        if ($result == 1) {
            $kq = array("success" => true, "data" => $result);
        } else {
            $kq = array("success" => false, "data" => $result);
        }
        echo json_encode($kq);
    } else if ($data->action === "profile") {
        $result = array('success' => true, "data" => $users->get_one($_SESSION['user_id']));
        echo json_encode($result);
    } else if ($data->action === "logout") {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
            $result = array('success' => true, "data" => 1);
            echo json_encode($result);
        } else {
            $result = array('success' => false, "data" => 0);
            echo json_encode($result);
        }

    } else if ($data->action === "admin-get-list") {
        if (isset($_SESSION['user_id'])) {
            $result = array('success' => true, "data" => $users->get_list());
            echo json_encode($result);
        }
    } else if ($data->action === "adminRights") {
        try{
            if (isset($_SESSION['user_id'])){
                $result = $users->get_one($_SESSION['user_id']);
                $admin_rights = $result['admin_rights'];
                if ($admin_rights == 1) {
                    $result = array('success' => true, "data" => "isAdmin");
                    echo json_encode($result);
                } else {
                    $result = array('success' => false, "data" => "notAdmin");
                    echo json_encode($result);
                }
            }
            else {
                $result = array('success' => false, "data" => "notAdmin");
                    echo json_encode($result);
            }
        }
        catch (Exception $e) {
            // Code that handles the exception
            $e->getMessage();
            echo json_encode($e);
        }
       
      
    } else {
        $result = array('success' => false, "data" => "Unknown action");
        echo json_encode($result);
    }
}
//PUT, DELETE
else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // parse_str(file_get_contents("php://input"), $request_body);
    // // Decode JSON data into a PHP object
    // $data = json_decode($request_body);
    // if(remove_one($data)){
    //     $kq = array('success' => true);
    //     echo json_encode($kq);
    // }else{
    //     $kq = array('success' => false,"message":"Error");
    //     echo json_encode($kq);
    // }
    echo '{"success":false, "message":"Method không hỗ trợ"}';
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    $kq = array('success' => true, "data" => $users->update_one($data));
    echo json_encode($kq);
}

?>