<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Subject and Room schedule management</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">

</head>

<body id="page-top">

  <?php 

    include "php/db.php";
    session_start();

    $stmt = $db->prepare("SELECT * FROM  user_information WHERE user_id = ?");
    $stmt->bind_param("s",$_SESSION['user_id']);
    $stmt->execute();
    $info = $stmt->get_result()->fetch_assoc();
    
  ?>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboardAdmin.php">
        <div class="sidebar-brand-icon">
         <img class="img-profile"  style="height: 5vh;" src="img/test2.png">
        </div>
        <div class="sidebar-brand-text mx-3"><img class="img-profile"  style="height: 4vh; margin-left: -1vw; margin-right: -1vw" src="img/test3.png"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="dashboardAdmin.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard Admin</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        MAIN NAVIGATION
      </div>
      <li class="nav-item">
        <a class="nav-link" href="registerTeacher.php">
         <i class="fas fa-fw fa-cog"></i>
          <span>Register Teacher</span></a>
      </li>
      <li class="nav-item  active">
        <a class="nav-link" href="registerDPD.php">
         <i class="fas fa-fw fa-cog"></i>
          <span>Register DPD</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="newRoom.php">
         <i class="fas fa-fw fa-cog"></i>
          <span>Add new Room</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Settings
      </div>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="profile.php">
         <i class="fas fa-fw fa-cog"></i>
          <span>Profile</span></a>
      </li>

      

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <h2>Subject and Room Management System</h2>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">


            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $info['info_first_name']?></span>
                <img class="img-profile rounded-circle" src="<?php echo $info['info_profile_picture'] ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <?php
            if(isset($_POST['submit'])){
              $email = $db->real_escape_string($_POST['email']);
              $password = password_hash($db->real_escape_string($_POST['password']), PASSWORD_BCRYPT );
              $confirmPassword = $db->real_escape_string($_POST['confirmPassword']);
              $firstName = $db->real_escape_string($_POST['firstName']);
              $lastName = $db->real_escape_string($_POST['lastName']);
              $department = 0;
              $type = 3;
              $course = 0;
              $address = $db->real_escape_string($_POST['address']);
              $gender = $db->real_escape_string($_POST['gender']);
              $dob = $db->real_escape_string($_POST['dob']);

              $stmt = $db->prepare("SELECT * FROM  user WHERE user_email = ?");
              $stmt->bind_param("s",$email);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                  echo "<div class='alert alert-danger alert-dismissible' role='alert' ><strong>Email already in used<button type='button' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times;</span></button></div>";
              }else{
                if($_POST['password'] != $_POST['confirmPassword']){
                  echo "<div class='alert alert-danger alert-dismissible' role='alert' ><strong>Password do not match<button type='button' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times;</span></button></div>";
                }else{
                  $stmt = $db->prepare("INSERT INTO user (user_email, user_password, department_id, course_id, user_type) VALUES (?,?,?,?,?)");
                  $stmt->bind_param("ssiii", $email, $password, $department, $course, $type);
                  if($stmt->execute()){
                     $stmt = $db->prepare("SELECT * FROM  user WHERE user_email = ?");
                     $stmt->bind_param("s",$email);
                     $stmt->execute();
                     $result = $stmt->get_result()->fetch_assoc();
                     if($gender == "Male"){
                      $profile = "img/Male.png";
                     }else{
                      $profile = "img/Female.png";
                     }

                     $stmt2 = $db->prepare("INSERT INTO user_information (user_id, info_first_name, info_last_name, info_address, info_gender, info_dob, info_profile_picture) VALUES (?,?,?,?,?,?,?)");
                     $stmt2->bind_param("issssss", $result['user_id'], $firstName, $lastName, $address, $gender, $dob, $profile);
                     if($stmt2->execute()){
                         echo "<div class='alert alert-success alert-dismissible' role='alert' ><strong>DPD successfuly added<button type='button' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times;</span></button></div>";
                     }
                  }
                }
              } 
              
            }

          ?>

          <br>
          <!-- Content Row -->
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
          <div class="row">
             
                 <div class="col-sm-2 mb-1 mb-sm-0">
                  <input type="text" id="room" class="form-control " name="firstName" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh;   margin-bottom: 1vh" placeholder="First Name">
                </div>
                <div class="col-sm-2 mb-1 mb-sm-0">
                  <input type="text" id="room" class="form-control " name="lastName" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh;   margin-bottom: 1vh" placeholder="Last Name">
                </div>
                <div class="col-sm-2 mb-1 mb-sm-0">
                  <input type="email" id="room" class="form-control " name="email" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh;   margin-bottom: 1vh" placeholder="Email Address">
                </div>
                <div class="col-sm-2 mb-1 mb-sm-0">
                  <input type="password" id="room" class="form-control " name="password" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh;   margin-bottom: 1vh" placeholder="Password">
                </div>
                <div class="col-sm-2 mb-1 mb-sm-0">
                  <input type="password" id="room" class="form-control " name="confirmPassword" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh;   margin-bottom: 1vh" placeholder="Password">
                </div>

          </div>
          <div class="row">
                  <div class="col-sm-2 mb-1 mb-sm-0">
                    <select name="gender"  class="form-control " style="font-size: 0.8rem;border-radius: 10rem;height: 5vh">
                      <option value="" disabled selected>Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="col-sm-2 mb-1 mb-sm-0">
                     <input type="text" name="address"  class="form-control form-control-user" id="exampleInputAddress" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh;   margin-bottom: 1vh" placeholder="Address">
                  </div>
                  <div class="col-sm-2 mb-1 mb-sm-0">
                    <input name="dob" class="form-control form-control-user"  type="date" name="dob" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh;   margin-bottom: 1vh">
                  </div>
                <div class="col-sm-2 mb-1 mb-sm-0">
                  <input id="submit" class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="Submit"  style="font-size: 0.8rem;border-radius: 10rem;height: 5vh;   margin-bottom: 1vh">
                </div>
          </div>

          </form>

          

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="index.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
