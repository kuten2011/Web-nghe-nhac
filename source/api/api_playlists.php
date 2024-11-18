<?php
    class PLaylistController {  // class này chứa thông tin các playlist và các method xử lý dữ liệu
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
        public function get_list($kw = "") {    //lấy danh sách tất cả playlist
            $res = $this->db->query("SELECT * FROM playlists");
            // print_r($res);
            $rows = [];
            while($row = mysqli_fetch_assoc($res)) {
                $playlist_id=$row["playlist_id"];
                $tmp=$this->get_songs_of_playlist($playlist_id);
                // print_r($tmp);
                if(count($tmp)!=0)
                    $rows[] = $tmp;
                else
                    $rows[] = array($row);
                // print_r($tmp[0]);
            }
            return $rows;
        }
        public function get_one($playlist_id) { //lấy thông tin 1 playlist
            $res = $this->db->query("SELECT * FROM playlists where playlist_id='".$playlist_id."'");
            $rows = mysqli_fetch_assoc($res);
            return $rows;
        }
        public function get_songs_of_playlist($playlist_id){    //lấy các bài hát của 1 playlist
            $res = $this->db->query("SELECT * FROM playlists ,playlist_songs, songs, artists WHERE songs.artist_id=artists.artist_id AND playlist_songs.playlist_id=playlists.playlist_id AND songs.song_id=playlist_songs.song_id AND playlist_songs.playlist_id=".$playlist_id);
            // echo "SELECT * FROM playlist_songs, songs WHERE songs.song_id=playlist_songs.song_id AND playlist_songs.playlist_id=".$pi;
            $rows=[];
            while($row = mysqli_fetch_assoc($res)) {
                // print_r($row);
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
    $playlists = new PLaylistController;
    // $data = array('success' => true, "data"=> $playlists->get_list());
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action']==='get_inf') {
        //...
        //trả về json dssv
        $data = array('success' => true, "data"=> $playlists->get_list());
        echo json_encode($data);
        die;
        
    }else if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['playlist_id'])){

        $data = array('success' => true, "data"=> $playlists->get_songs_of_playlist($_GET['playlist_id']));
        // print_r($playlists->get_songs_of_playlist($_GET['playlist_id']));
        echo json_encode($data);
        die;

    }else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //thêm playlist
        // Get JSON data from request body
        header('Content-Type: application/json');
        $request_body = file_get_contents('php://input');
        // Decode JSON data into a PHP object
        $data = json_decode($request_body);
        if(add_one($data)){
            $kq = array('success' => true);
            echo json_encode($kq);
        }else{
            $kq = array('success' => false,"message"=> "Error");
            echo json_encode($kq);
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