<?php
session_start();
require_once("../php/user_class.php");
$users = new UserController;
$username = "TEXT";
$email = "TEXT";
$date = "TEXT";
$gender = "TEXT";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $users->get_one($user_id);
    $username = $result['username'];
    $email = $result['email'];
    $date = $result['date_of_birth'];
    $date = $users->changeDate($date);
    $gender = ucfirst($result['gender']);
} else {
    header("HTTP/1.0 404 Not Found"); 
    include("404.php");
    exit();
}
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>SoundV Profile</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../images/Logo-icon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Profile overview</title>
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
            padding-top: 100px;
            padding-left: 100px;
            padding-right: 100px;
        }

        #main-content {
            font-size: 1.4rem;
        }
    </style>
</head>

<body>
    <div class="containner">
        <div class="row">
            <div class="col-sm-4 col-md-2 col-lg-2 bg-dark p-4" style="min-height: 98vh; color: white;">
                <a href="../index.html" id="home_url">
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
                <h1>Profile Overview</h1>
                <div class="containner mt-5">
                    <div class="row p-3" id="main-content">
                        <div class="col">
                            <h4>Username</h4>
                        </div>
                        <div class="col" id="username">
                            <?php
                            echo $username; ?>
                        </div>
                        <hr style="height: 1.2px;">
                    </div>
                    <div class="row p-3" id="main-content">
                        <div class="col">
                            <h4>Email</h4>
                        </div>
                        <div class="col" id="email">
                            <?php echo $email; ?>
                        </div>
                        <hr style="height: 1.2px;">
                    </div>
                    <div class="row p-3" id="main-content">
                        <div class="col">
                            <h4>Date of birth</h4>
                        </div>
                        <div class="col" id="dateofbirth">
                            <?php echo $date; ?>
                        </div>
                        <hr style="height: 1.2px;">
                    </div>
                    <div class="row p-3" id="main-content">
                        <div class="col">
                            <h4>Gender</h4>
                        </div>
                        <div class="col" id="gender">
                            <?php echo $gender; ?>
                        </div>
                        <hr style="height: 1.2px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>