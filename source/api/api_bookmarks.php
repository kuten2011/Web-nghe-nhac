<?php
session_start();
class BookmarkController    // class này chứa thông tin bookmark và các method xử lý dữ liệu
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
    public function get_list($kw = "")   //lấy danh sách tất cả bookmark
    {
        $res = $this->db->query("SELECT * FROM bookmark");
        $rows = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function get_one($user_id) //lấy danh sách bài hát đã được thích bởi user_id
    {
        $res = $this->db->query("SELECT * FROM bookmark WHERE user_id=" . $user_id);
        $rows = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function remove_like($song_id, $user_id)  //xoá bookmark với song_id và user_id
    {
        $stmt = $this->db->prepare("DELETE FROM bookmark WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result ? true : false;
    }
    public function add_like($song_id, $user_id) { //thêm bookmark với song_id và user_id
        $stmt = $this->db->prepare("INSERT INTO bookmark (song_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $song_id, $user_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
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
$bookmarks = new BookmarkController;
// $data = array('success' => true, "data"=> $bookmarks->get_list());
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //...
    //trả về json dssv
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $data = array('success' => true, "data" => $bookmarks->get_one($user_id)); //danh sách bookmarks của user_id
        echo json_encode($data);
        die();
    } else {
        $data = array('success' => true, "data" => $bookmarks->get_list());
        echo json_encode($data);
        die();
    }

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get JSON data from request body
    $request_body = file_get_contents('php://input');
    // Decode JSON data into a PHP object
    $data = json_decode($request_body);
    if ($data->action === "remove-like") {
        if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $remove = $bookmarks->remove_like($data->song_id, $user_id);
                $kq = array('success' => $remove);  
            }
        else {
            $kq = array('success' => false, 'msg'=> "Not logged in");
        }  
    }
    else if ($data->action === "add-like") {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $remove = $bookmarks->add_like($data->song_id, $user_id);
            $kq = array('success' => $remove);  
        }
        else {
            $kq = array('success' => false, 'msg'=> "Not logged in");
        }  
    }
    else {
        $kq = array('success' => false, "message" => "Error");
    }
    
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