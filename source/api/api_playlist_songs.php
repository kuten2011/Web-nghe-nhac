<?php
    class PLaylist_Songs_Controller {  // class này chứa thông tin playlist và các bài hát của playlist và các method xử lý dữ liệu
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
        public function get_list($kw = "") {    // lấy tất cả các cặp playlist và song
            $res = $this->db->query("SELECT * FROM playlist_songs");
            $rows = [];
            
            while($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
        public function get_songs_of_playlist($playlist_id) {   //lấy các bài hát của 1 playlist
            $res = $this->db->query("SELECT * FROM playlist_songs where playlist_id=".$playlist_id);
            $rows = [];
            while($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row;
            }
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
    $playlist_songs = new PLaylist_Songs_Controller;
    // $data = array('success' => true, "data"=> $playlist_songs->get_list());
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //...
        //trả về json dssv
        $data = array('success' => true, "data"=> $playlist_songs->get_list());
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