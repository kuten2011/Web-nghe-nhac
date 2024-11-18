<?php
    class AlbumController {   // class để chứa các thông tin album cần thiết và các phương thức lấy thông tin từ database
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
        public function get_list($kw = "") {   //lấy danh sách tất cả album và nghệ sĩ của nó
            $res = $this->db->query("SELECT * FROM albums, artists where albums.artist_id=artists.artist_id");
            $rows = [];
            while($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
        public function get_one($album_id) {  //lấy 1 album và nghệ sĩ của nó
            $res = $this->db->query("SELECT * FROM albums, artists where albums.artist_id=artists.artist_id AND album_id=".$album_id);
            $rows = mysqli_fetch_assoc($res);
            return $rows;
        }
        public function get_song_album($album_id) {  //lấy các bài hát của 1 album và nghệ sĩ của nó
            $res = $this->db->query("SELECT * FROM songs s , albums al, artists a where s.album_id=al.album_id and al.artist_id=a.artist_id AND al.album_id=".$album_id);
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
    $albums = new AlbumController;
    // $data = array('success' => true, "data"=> $albums->get_list());
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //...
        //trả về json dssv
        if(isset($_GET['action']) && $_GET['action']==='get_songs_album' && isset($_GET['album_id'])){  
            $data = array('success' => true, "data"=> $albums->get_song_album($_GET['album_id']));
            echo json_encode($data);
            // print_r($albums->get_song_album($_GET['album_id']));
            die();
        }else{
            $data = array('success' => true, "data"=> $albums->get_list());
            echo json_encode($data);
            die();
        }
        
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