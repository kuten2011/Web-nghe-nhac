<?php
    class ArtistController {    // class chứa các thông tin cần thiết về Artist và các phương thức xử lý dữ liệu
        private $db;
        public function __construct()
        {
            $this->db = new mysqli('localhost', 'root', '', 'music_db');
            if ($this->db->connect_errno) 
                die ("Lỗi kết nối: " . $this->db->connect_error);
        }
        public function __destruct()
        {
            $this->db->close();
        }
        public function get_list($kw = "") {   //lấy danh sách tất cả các artist
            $res = $this->db->query("SELECT * FROM artists");
            $rows = [];
            while($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
        public function get_one($artist_id) { //lấy 1 artist
            $res = $this->db->query("SELECT * FROM artists WHERE artist_id=".$artist_id);
            $rows = mysqli_fetch_assoc($res);
            return $rows;
        }
        // public function add_one($data){
        //     $mssv=$data->mssv;
        //     $hoten=$data->hoten;
        //     $namsinh=(int)($data->namsinh);
        //     $malop=$data->malop;
        //     $sql="INSERT INTO sinhvien VALUE ($mssv, $hoten, $namsinh, $malop)";
        //     if($this->db->query($sql))
        //         return true;
        //     else
        //         return false;
        // }
        // public function remove_one($data){
        //     $mssv=$data->mssv;
        //     $sql="DELETE FROM sinhvien WHERE mssv=".$mssv;
        //     if($this->db->query($sql))
        //         return true;
        //     else
        //         return false;
        // }
    }
    header('Content-Type: application/json; charset=utf-8');
    $artists = new ArtistController;
    // $data = array('success' => true, "data"=> $artists->get_list());
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //...
        //trả về json dssv
        $data = array('success' => true, "data"=> $artists->get_list());
        echo json_encode($data);
        die();
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // //thêm sv
        // // Get JSON data from request body
        // $request_body = file_get_contents('php://input');
        // // Decode JSON data into a PHP object
        // $data = json_decode($request_body);
        // if(add_one($data)){
        //     $kq = array('success' => true);
        //     echo json_encode($kq);
        // }else{
        //     $kq = array('success' => false,"message":"Error");
        //     echo json_encode($kq);
        // }
            
        echo '{"success":false, "message":"Method Chưa hỗ trợ"}';
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
    }
?>