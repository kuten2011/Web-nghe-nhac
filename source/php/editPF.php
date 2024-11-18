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
    if (isset($_POST['save'])) {
        $thongtin = array(
            "user_id" => $user_id,
            "username" => $_POST['username'],
            "email" => $_POST['email'],
            "password" => "",
            "dateofbirth" => $users->changeDateSQL($_POST['date']),
            "gender" => $_POST['gender']
        );
        $thongtin = json_encode($thongtin);
        $thongtin = json_decode($thongtin);
        $result = $users->update_one($thongtin);
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
    <title>SoundV Edit Profile</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../images/Logo-icon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Edit profile</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
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
    <script>
        $(function () {
            $('#datepicker').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        })
    </script>
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
                            <a href="../php/profile.php" id="profile_url"><i class="fas fa-home"
                                    style="font-size: 1.5rem;"></i>Overview</a>
                        </label>
                    </li>
                    <li class="danhmuc">
                        <label>
                            <a href="../php/editPF.php" id="editPF_url"><i class="fas fa-user-edit"
                                    style="font-size: 1.5rem;"></i></i>Edit Profile</a>
                        </label>
                    </li>
                    <li class="danhmuc">
                        <label>
                            <a href="../php/changePW.php" id="changePW_url"><i class="fas fa-edit"
                                    style="font-size: 1.5rem;"></i>Change Password</a>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="col-sm-8 col-md-9 col-lg-10" id="contents">
                <h1>Edit Profile</h1>
                <div class="containner mt-5">
                    <form action="" method="POST">
                        <div class="row p-3">
                            <div class="col-5">
                                <h4>Username</h4>
                            </div>
                            <div class="col-7" id="username">
                                <input type="text" name="username" class="form-control p-4"
                                    style="border-radius: 30px; font-size: 1.1rem;" placeholder=<?php echo $username ?>>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-5">
                                <h4>Email</h4>
                            </div>
                            <div class="col-7" id="email">
                                <input type="text" name="email" class="form-control p-4"
                                    style="border-radius: 30px; font-size: 1.1rem;" placeholder=<?php echo $email ?>>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-5">
                                <h4>Date of birth</h4>
                            </div>
                            <div class="col-7" id="dateofbirth">
                                <input type="text" name="date" id="datepicker" class="form-control p-4"
                                    style="border-radius: 30px; font-size: 1.1rem;" placeholder=<?php echo $date ?>>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-5">
                                <h4>Gender</h4>
                            </div>
                            <div class="col-7" id="gender">
                                <!-- <input type="text" class="form-control p-4" style="border-radius: 30px; font-size: 1.1rem;" placeholder="Gender"> -->
                                <select class="form-select form-select-lg p-4" name="gender"
                                    aria-label=".form-select-sm example"
                                    style="border-radius: 30px; font-size: 1.1rem;">
                                    <!-- <option selected>Gender</option> -->
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="p-2 text-center" id="msg" style="border-radius: 10px; font-size: 1.1rem;">
                            <?php
                            if (!$result) {
                                echo "Failed";
                            }

                            ?>
                        </div>

                        <div class="row p-3">
                            <div class="col-10"></div>
                            <div class="col-2">
                                <button type="submit" name="save" class="btn btn-info" id="btnsave">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>