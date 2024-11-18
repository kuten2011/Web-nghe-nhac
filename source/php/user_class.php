<?php
class UserController        // class này chứa thông tin user và các method xử lý dữ liệu
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
    public function get_list($kw = "")      //lấy tất cả user
    {
        $res = $this->db->query("SELECT * FROM users");
        $rows = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function get_one($user_id)       //lấy 1 user
    {
        $res = $this->db->query("SELECT * FROM users where user_id=" . $user_id);
        $rows = mysqli_fetch_assoc($res);

        return $rows;
    }
    public function add_one($data)      //thêm 1 user
    {
        $usn = $data->username;
        $pw = $data->password;
        $date = $data->dateofbirth;
        $email = $data->email;
        $gender = $data->gender;

        if (
            preg_match(
                "/^[a-zA-Z0-9]{8,}$/",
                $usn
            )
            && preg_match(
                "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}/",
                $pw
            )
            && preg_match(
                "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",
                $email
            )
        ) {
            $sql_u = "SELECT * FROM users WHERE username='$usn'";
            $res_u = mysqli_query($this->db, $sql_u);
            if (mysqli_num_rows($res_u) > 0) {
                return "Username has already taken.";
            }
            $sql = "INSERT INTO users (username,password,email,date_of_birth,gender,admin_rights) 
                VALUE ('" . $usn . "', '" . $pw . "', '" . $email . "', '" . $date . "', '" . $gender . "', 0)";
            // return $sql;
            if ($this->db->query($sql))
                return true;
            else
                return "Cannot connect to database.";
        } else {
            return "Invalid input.";
        }
    }
    public function update_one($data)  // sửa đổi 1 user
    {
        $sql = "UPDATE users SET";
        if ($data->user_id != "") {
            $old_data = $this->get_one($data->user_id);
            if ($data->username != "")
                $sql .= " username='" . $data->username . "'";
            else
                $sql .= " username='" . $old_data["username"] . "'";

            if ($data->email != "")
                $sql .= " , email='" . $data->email . "'";
            else
                $sql .= " , email='" . $old_data["email"] . "'";

            if ($data->password != "")
                $sql .= " , password='" . $data->password . "'";
            else
                $sql .= " , password='" . $old_data["password"] . "'";

            if ($data->gender != "")
                $sql .= " , gender='" . $data->gender . "'";
            else
                $sql .= " , gender='" . $old_data["gender"] . "'";

            if ($data->dateofbirth != "")
                $sql .= " , date_of_birth='" . $data->dateofbirth . "'";
            else
                $sql .= " , date_of_birth='" . $old_data["date_of_birth"] . "'";

            $sql .= " WHERE user_id=" . $data->user_id;
        }
        if ($this->db->query($sql)){
            header("Refresh:0");
            return true;
        }
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
    public function changeDate($dateStr)    //chuyển đổi date sang dạng dd/mm/yyyy
    {
        $timestamp = strtotime($dateStr);
        // Format the timestamp as "dd/mm/yyyy"
        $formattedDate = date('d/m/Y', $timestamp);
        // Return the formatted date string
        return $formattedDate;
    }
    function changeDateSQL($date)       //chuyển đổi date sang dạng yyyy/mm/dd
    {
        // convert the date to timestamp
        $timestamp = strtotime($date);
        // format the date to yyyy-mm-dd
        $new_date = date('Y-m-d', $timestamp);
        // return the new date
        return $new_date;
    }
    function checkPass($data, $psw){  //kiểm tra mật khẩu đã nhập
        $pw_input=$data["pw_input"];
        $new_pw=$data["new_pw"];
        $rnew_pw=$data["rnew_pw"];
        if ($pw_input==='' || $new_pw==='' || $rnew_pw===''){
            return "Please enter all.";
        }
        if ($psw!=$pw_input || $psw===''){
            return "Wrong password";
        }
        if ($psw===$new_pw || $psw===$rnew_pw){
            return "Enter new different password";
        }
        if ($pw_input===$new_pw || $pw_input===$rnew_pw){
            return "Enter new different password";
        }
        if ($new_pw!=$rnew_pw){
            return "Password confirmation must be the same as new password";
        }
        $reg = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';
        if (!preg_match($reg, $new_pw)){
            return "Password at least 8 characters with at least 1 number, 1 letter, 1 special character.";
        }
        return "success";
    }
}
?>