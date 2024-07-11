<?php 
include 'Includes/dbcon.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>AMS - Login</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpg');">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <img src="img/logo/attnlg.jpg" style="width:100px;height:100px"><br>
                    <br><h5 align="center">MANAGEMENT SYSTEM</h5><br><br>
                    <h1 class="h4 text-gray-900 mb-4">Staff Login Panel</h1>
                  </div>
                  <form class="user" method="Post" action="">
                    <div class="form-group">
                      <select required name="userType" class="form-control mb-3">
                        <option value="">--Select User Roles--</option>
                        <option value="Administrator">Administrator</option>
                        <option value="ClassTeacher">ClassTeacher</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" required name="username" id="exampleInputEmail" placeholder="Enter Email Address">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" required class="form-control" id="exampleInputPassword" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-success btn-block" value="Login" name="login" />
                    </div>
                  </form>
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Forgot Password?</a>
                  </div>

<?php

if(isset($_POST['login'])){
    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = md5($password);

    if($userType == "Administrator"){
        $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND password = '$password'";
        $rs = $conn->query($query);
        $num = $rs->num_rows;
        $rows = $rs->fetch_assoc();

        if($num > 0){
            $_SESSION['userId'] = $rows['Id'];
            $_SESSION['firstName'] = $rows['firstName'];
            $_SESSION['lastName'] = $rows['lastName'];
            $_SESSION['emailAddress'] = $rows['emailAddress'];
            echo "<script type = \"text/javascript\">window.location = (\"Admin/index.php\")</script>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Invalid Username/Password!</div>";
        }
    } else if($userType == "ClassTeacher"){
        $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
        $rs = $conn->query($query);
        $num = $rs->num_rows;
        $rows = $rs->fetch_assoc();

        if($num > 0){
            $_SESSION['userId'] = $rows['Id'];
            $_SESSION['firstName'] = $rows['firstName'];
            $_SESSION['lastName'] = $rows['lastName'];
            $_SESSION['emailAddress'] = $rows['emailAddress'];
            
            // Fetch classId and classArmId from tblteacherclass
            $teacherId = $rows['Id'];
            $teacherClassQuery = "SELECT classId, classArmId FROM tblteacherclass WHERE teacherId = '$teacherId'";
            $teacherClassResult = $conn->query($teacherClassQuery);
            if ($teacherClassResult->num_rows > 0) {
                $teacherClass = $teacherClassResult->fetch_assoc();
                $_SESSION['classId'] = $teacherClass['classId'];
                $_SESSION['classArmId'] = $teacherClass['classArmId'];
            } else {
                $_SESSION['classId'] = null;
                $_SESSION['classArmId'] = null;
            }

            echo "<script type = \"text/javascript\">window.location = (\"ClassTeacher/index.php\")</script>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Invalid Username/Password!</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Invalid Username/Password!</div>";
    }
}
?>

                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span> &copy; <script> document.write(new Date().getFullYear()); </script> - Developed by RAHUL, KESHAV,ABHISHEK & ADARSH 
      <br><br>
      NEEV MANAGEMENT SYSTEM
      </span>
    </div>
  </div>
</footer>
</html>
