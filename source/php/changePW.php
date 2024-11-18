<?php
session_start();
require_once("../php/user_class.php");
$users = new UserController;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $users->get_one($user_id);
    $pass = $result['password'];
    $check = '';
    
    if (isset($_POST['save'])) {
        $thongtinPW = array(
            "pw_input" => $_POST['current'],
            "new_pw" => $_POST['pass'],
            "rnew_pw" => $_POST['cfpass']
        );
        $check = $users->checkPass($thongtinPW, $pass);
        if ($check === 'success') {
            $thongtin = array(
                "user_id" => $user_id,
                "username" => "",
                "email" => "",
                "password" => $_POST['pass'],
                "dateofbirth" => "",
                "gender" => ""
            );
            $thongtin = json_encode($thongtin);
            $thongtin = json_decode($thongtin);
            $resultSQL = $users->update_one($thongtin);
        }
    }
} else {
    header("HTTP/1.0 404 Not Found"); 
    include("404.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>SoundV Change Password</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../images/Logo-icon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Change password</title>
    <style>
        * {
            box-sizing: border-box;
        }

        .dropdown-item {
            color: white;
        }

        .danhmuc a {
            text-decoration: none;
            color: aqua;
        }

        .danhmuc {
            list-style: none;
            margin-bottom: 40px;
        }

        .fas {
            margin-right: 10px;
        }

        .danhmuc a:hover {
            color: #0b707d;
        }

        body {
            width: 100%;
        }

        #contents {
            padding-top: 50px;
            padding-left: 100px;
            padding-right: 100px;
        }

        #main-content {
            font-size: 1.4rem;
        }

        #btnsave {
            border-radius: 30px;
            width: 100%;
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="containner">
        <div class="row">
            <div class="col-sm-4 col-md-2 col-lg-2 bg-dark p-4" style="min-height: 98vh; color: white;">
                <a href="../index.html">
                    <img src="../images/Logo.png" class="mb-5" width="100%">
                </a>
                <ul class="menu-danhmuc">
                    <li class="danhmuc">
                        <label>
                            <a href="profile.php" id="profile_url"><i class="fas fa-home"
                                    style="font-size: 1.5rem;"></i>Overview</a>
                        </label>
                    </li>
                    <li class="danhmuc">
                        <label>
                            <a href="editPF.php" id="editPF_url"><i class="fas fa-user-edit"
                                    style="font-size: 1.5rem;"></i></i>Edit Profile</a>
                        </label>
                    </li>
                    <li class="danhmuc">
                        <label>
                            <a href="changePW.php" id="changePW_url"><i class="fas fa-edit"
                                    style="font-size: 1.5rem;"></i>Change Password</a>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="col-sm-8 col-md-9 col-lg-10" id="contents">
                <h1>Change Password</h1>
                <form class="containner mt-5" method="POST">
                    <div class="row p-3">
                        <div class="col-5">
                            <h4>Current password:</h4>
                        </div>
                        <div class="col-7" id="curpw">
                            <input type="text" name="current" class="form-control p-4"
                                style="border-radius: 30px; font-size: 1.1rem;" placeholder="Current password">
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col-5">
                            <h4>New password:</h4>
                        </div>
                        <div class="col-7" id="newpw">
                            <input type="password" name="pass" class="form-control p-4"
                                style="border-radius: 30px; font-size: 1.1rem;" placeholder="New password">
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col-5">
                            <h4>Repeat new password:</h4>
                        </div>
                        <div class="col-7" id="rnewpw">
                            <input type="password" name="cfpass" class="form-control p-4"
                                style="border-radius: 30px; font-size: 1.1rem;" placeholder="Repeat new password">
                        </div>
                    </div>
                    <?php
                    // if (isset($_POST['save']) && $check!=''){
                        if ($check != 'success' ) {
                            echo '<div class="pe-4 mt-2 text-end" id="msg" style="font-weight: 500; color:red; border-radius: 10px; font-size: 1.1rem;">'.$check.'</div>';
                        } else if (!$resultSQL) {
                            echo '<div class="pe-4 text-end" id="msg" style="font-weight: 500; color:red; border-radius: 10px; font-size: 1.1rem;">Fail</div>';
                        } 
                    // }
                    
                    ?>
                    <div class="p-2 text-center" id="msg" style="border-radius: 10px; font-size: 1.1rem;"></div>

                    <div class="row p-3">
                        <div class="col-10"></div>
                        <div class="col-2">
                            <button name="save" type="submit" class="btn btn-info" id="btnsave">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>