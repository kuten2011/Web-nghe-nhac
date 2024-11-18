<?php
session_start();
class BaiHatController // class này chứa thông tin Bài hát và các method xử lý dữ liệu
{
    private $db;
    public function __construct()
    {
        $this->db = new mysqli('localhost', 'root', '', 'music_db');
        if ($this->db->connect_errno)
            die("Lỗi kết nối: " . $this->db->connect_error);
    }
    public function __destruct()
    {
        $this->db->close();
    }
    public function get_list_by_country($country)
{
    $query = "SELECT * FROM songs s INNER JOIN artists a ON s.artist_id = a.artist_id WHERE a.nationality like '%" . $country . "%'";
    $res = $this->db->query($query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
    return $rows;
}
    public function get_list($country = "") //lấy tất cả các bài hát có trong database
    {
        $query = "SELECT * FROM songs s INNER JOIN artists a ON s.artist_id = a.artist_id";
        $res = $this->db->query($query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function get_one($song_id) //lấy thông tin của 1 bài hát
    {
        $res = $this->db->query("UPDATE songs set listens=(SELECT listens from songs where song_id=" . $song_id . ")+1 where song_id=" . $song_id);
        $res = $this->db->query("SELECT * FROM songs s, artists a where s.artist_id = a.artist_id AND s.song_id=" . $song_id);
        $rows = mysqli_fetch_assoc($res);
        // echo $rows['album_id'];
        if ($rows['album_id'] == null || $rows['album_id'] == '') {
            return $rows;
        } else {
            $res = $this->db->query("SELECT * FROM songs s, artists a, albums al where al.album_id=s.album_id and s.artist_id = a.artist_id AND s.song_id=" . $song_id);
            $rows = mysqli_fetch_assoc($res);
        }
        return $rows;
    }
    public function search($input)
    { //search danh sách bài hát với $input
        $res = $this->db->query("SELECT * FROM songs inner join artists on songs.artist_id = artists.artist_id where songs.song_title like '%" . $input . "%'");
        $rows = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function get_chart() //lấy danh sách bài hát được sắp xếp theo bảng xếp hạng
    {
        $res = $this->db->query("SELECT * FROM songs s INNER JOIN artists a ON s.artist_id = a.artist_id ORDER BY listens DESC LIMIT 5");
        $rows = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function get_like() //lấy danh bài hát đã thích của user_id
    {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $res = $this->db->query("SELECT songs.song_id FROM songs INNER JOIN bookmark ON songs.song_id = bookmark.song_id WHERE user_id =" . $user_id);
            $rows = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row['song_id'];
            }
            return $rows;
        }
        return false;

    }
    public function get_likesong_page() //lấy danh bài hát đã thích của user_id và artist của bài hát đó
    {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $query = "  SELECT * FROM songs 
                        INNER JOIN bookmark ON songs.song_id = bookmark.song_id 
                        INNER JOIN artists ON songs.artist_id = artists.artist_id
                        WHERE user_id =";
            $res = $this->db->query($query . $user_id);
            $rows = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
        return false;

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
$songs = new BaiHatController;
// $data = array('success' => true, "data"=> $songs->get_list());

#Trả về các dữ liệu cần thiết về phía người dùng.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //...
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'get_chart') {
            $data = array('success' => true, "data" => $songs->get_chart());
            echo json_encode($data);
            die();
        }
    } else if (isset($_GET['song_id'])) {
        $data = [];
        $data[] = $songs->get_one($_GET['song_id']);
        $kq = array('success' => true, "data" => $data);
        echo json_encode($kq);
        // print_r($data);
        die();
    } else {
        $dataLike = $songs->get_like();
        $data = array('success' => true, "data" => $songs->get_list(), "dataLike" => $dataLike, "isLogin" => isset($_SESSION['user_id']));
        echo json_encode($data);
        die();
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    if ($data->action == "search") {
        $regSearch = "/^[\p{L}\d\s]+$/u";
        if (preg_match($regSearch, $data->input)) {
            $dataLike = $songs->get_like();
            $kq = array("data" => $songs->search($data->input),"dataLike"=> $dataLike,  "isLogin"=>isset($_SESSION['user_id']));
        } else {
            $kq = array("data" => "Invalid Input");
        }
    } else if ($data->action === "like-song-page") {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $kq = array('success' => true, "data" => $songs->get_likesong_page(), "isLogin"=>true);
        } else {
            $kq = array('success' => false, 'msg' => "Not logged in", "isLogin"=>false);
        }
    } else if ($data->action === "admin-get-list") {
        $kq = array("data" => $songs->get_list());
    } else if ($data->action === "select-country") {
        $dataLike = $songs->get_like();
        $kq = array("action"=> "country", "data" => $songs->get_list_by_country($data->country), "dataLike"=> $dataLike,  "isLogin"=>isset($_SESSION['user_id']));
    } else {
        $kq = array('success' => false, 'msg' => "Unknown action");
    }
    // else if ($data->action === "like-song-page") {
    //     if (isset($_SESSION['user_id'])) {
    //         $user_id = $_SESSION['user_id'];
    //         $kq = array('success' => true, "data" => $songs->get_likesong_page());
    //     } else {
    //         $kq = array('success' => false, 'msg' => "Not logged in");
    //     }
    // } else if ($data->action === "admin-get-list") {
    //     $kq = array("data" => $songs->get_list());
    // } else if ($data->action === "select-country") {
    //     $kq = array("action"=> "country", "data" => $songs->get_list_by_country($data->country));
    // } else {
    //     $kq = array('success' => false, 'msg' => "Unknown action");
    // }
    echo json_encode($kq);
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