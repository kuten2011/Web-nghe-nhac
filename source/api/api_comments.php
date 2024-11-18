<?php
    session_start();
    class CommentController { // class này chứa thông tin comment và các method xử lý dữ liệu
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
        public function get_list($kw = "") {    //lấy danh sách tất cả comment
            $res = $this->db->query("SELECT * FROM comment");
            $rows = [];
            while($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
        public function get_one($user_id) {     //lấy danh sách comment của user_id
            $res = $this->db->query("SELECT * FROM users u, comment c WHERE c.user_id=u.user_id AND c.user_id=".$user_id);
            $rows = [];
            while($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
        public function add_one($data){
            $song_id=$data->song_id;
            $ctn=$data->content;
            $user_id=$_SESSION['user_id'];
            $sql="INSERT INTO comment (user_id, song_id, content) VALUES (".$user_id.",".$song_id.",'".$ctn."')";
            if($this->db->query($sql))
                return true;
            else
                return false;
        }
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
    $comments = new CommentController;
    // $data = array('success' => true, "data"=> $comments->get_list());
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //...
        //trả về json dssv
        // $thongtin=array(
        //     "song_id"=> 4000001,
        //     "content"=> 'asd'
        // );
        // $thongtin1=json_decode(json_encode($thongtin));
        // print_r($thongtin1);
        // $comments->add_one($thongtin1);
        // die();
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            $data = array('success' => true, "data"=> $comments->get_one($user_id)); //danh sách comments của user_id
            echo json_encode($data);
            die();
        }else{
            $data = array('success' => true, "data"=> $comments->get_list());
            echo json_encode($data);
            die();
        }
        
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //thêm sv
        // Get JSON data from request body
        if(isset($_SESSION['user_id'])){
            
            $request_body = file_get_contents('php://input');
            // Decode JSON data into a PHP object
            $data = json_decode($request_body);
            // echo json_encode(add_one($data));
            // die();
            if($data->action=="add_cmt" and $comments->add_one($data)){
                $kq = array('success' => true);
                echo json_encode($kq);
                die();
            }else{
                $kq = array('success' => false,"message"=>"Error");
                echo json_encode($kq);
                die();
            }
        }
        
            
        // echo '{"success":false, "message":"Method Chưa hỗ trợ"}';
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