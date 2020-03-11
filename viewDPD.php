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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboardDPD.php">
        <div class="sidebar-brand-icon">
         <img class="img-profile"  style="height: 5vh;" src="img/test2.png">
        </div>
        <div class="sidebar-brand-text mx-3"><img class="img-profile"  style="height: 4vh; margin-left: -1vw; margin-right: -1vw" src="img/test3.png"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="dashboardDPD.php">
          <i class="fas fa-columns"></i>
          <span>Dashboard DPD</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        MAIN NAVIGATION
      </div>
      <li class="nav-item">
        <a class="nav-link" href="scheduleSection.php">
         <i class="fas fa-fw fa-calendar-plus "></i>
          <span>Schedule Section</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="schedule.php">
         <i class="fas fa-fw fa-calendar-plus "></i>
          <span>Schedule Student</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="scheduleMultiple.php">
         <i class="fas fa-fw fa-calendar-plus "></i>
          <span>Assign Students to Section</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="scheduleTeacher.php">
         <i class="fas fa-fw fa-calendar-plus "></i>
          <span>Schedule Teacher</span></a>
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

          <br>
          <!-- Content Row -->
          <div class="row">
              <?php

                if($_GET['search'] == 'students'){
                  echo '<table id="table" class="table" style="table-layout: auto; overflow-x: scroll;">
                    <thead  class="bg-primary  table-bordered " style="color:white;"> 
                      <tr> 
                        <th colspan="1">First Name</th>
                        <th colspan="1">Last Name</th>
                        <th colspan="1">Address</th>
                        <th colspan="1">Gender</th>
                        <th colspan="1">Date of Birth</th>
                      </tr>
                    </thead> 
                    <tbody class=" table-bordered ">'; 
                      $stmt = $db->prepare("SELECT * FROM  user WHERE user_type = 1");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      while ($value = $result->fetch_assoc()) {
                          $stmt2 = $db->prepare("SELECT * FROM  user_information WHERE user_id = ?");
                          $stmt2->bind_param('i',$value['user_id']);
                          $stmt2->execute();
                          $result2 = $stmt2->get_result();
                          while ($value2 = $result2->fetch_assoc()) {
                          echo '<tr><td>'.$value2['info_first_name'].'</td><td>'.$value2['info_last_name'].'</td><td>'.$value2['info_address'].'</td><td>'.$value2['info_gender'].'</td><td>'.$value2['info_dob'].'</td></tr>';
                        }
                      }
                      
                    echo '
                    </tbody>
                  </table>';
                }

                else if($_GET['search'] == 'teachers'){
                  echo '<table id="table" class="table" style="table-layout: auto; overflow-x: scroll;">
                    <thead  class="bg-primary  table-bordered " style="color:white;"> 
                      <tr> 
                        <th colspan="1">First Name</th>
                        <th colspan="1">Last Name</th>
                        <th colspan="1">Address</th>
                        <th colspan="1">Gender</th>
                        <th colspan="1">Date of Birth</th>
                      </tr>
                    </thead> 
                    <tbody class=" table-bordered ">'; 
                      $stmt = $db->prepare("SELECT * FROM  user WHERE user_type = 2");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      while ($value = $result->fetch_assoc()) {
                          $stmt2 = $db->prepare("SELECT * FROM  user_information WHERE user_id = ?");
                          $stmt2->bind_param('i',$value['user_id']);
                          $stmt2->execute();
                          $result2 = $stmt2->get_result();
                          while ($value2 = $result2->fetch_assoc()) {
                          echo '<tr><td>'.$value2['info_first_name'].'</td><td>'.$value2['info_last_name'].'</td><td>'.$value2['info_address'].'</td><td>'.$value2['info_gender'].'</td><td>'.$value2['info_dob'].'</td></tr>';
                        }
                      }
                      
                    echo '
                    </tbody>
                  </table>';
                }

                 else if($_GET['search'] == 'subject'){
                  echo '<table id="table" class="table" style="table-layout: auto; overflow-x: scroll;">
                    <thead  class="bg-primary  table-bordered " style="color:white;"> 
                      <tr> 
                        <th colspan="1">Subject Name</th>
                        <th colspan="1">Subject Code</th>
                      </tr>
                    </thead> 
                    <tbody class=" table-bordered ">'; 
                      $stmt = $db->prepare("SELECT * FROM  subject");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      while ($value = $result->fetch_assoc()) {
                          echo '<tr><td>'.$value['subject_name'].'</td><td>'.$value['subject_code'].'</td></tr>';
                      }
                      
                    echo '
                    </tbody>
                  </table>';
                }
                else if($_GET['search'] == 'section'){
                  echo '<table id="table" class="table" style="table-layout: auto; overflow-x: scroll;">
                    <thead  class="bg-primary  table-bordered " style="color:white;"> 
                      <tr> 
                        <th colspan="1">Section Name</th>
                      </tr>
                    </thead> 
                    <tbody class=" table-bordered ">'; 
                      $stmt = $db->prepare("SELECT * FROM  section");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      while ($value = $result->fetch_assoc()) {
                         echo '<tr><td>'.$value['section_name'].'</td></tr>';
                      }
                      
                    echo '
                    </tbody>
                  </table>';
                }
                else if($_GET['search'] == 'classroom'){
                  echo '<table id="table" class="table" style="table-layout: auto; overflow-x: scroll;">
                    <thead  class="bg-primary  table-bordered " style="color:white;"> 
                      <tr> 
                        <th colspan="1">Room Name</th>
                      </tr>
                    </thead> 
                    <tbody class=" table-bordered ">'; 
                      $stmt = $db->prepare("SELECT * FROM  room");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      while ($value = $result->fetch_assoc()) {
                         echo '<tr><td>'.$value['room_name'].'</td></tr>';
                      }
                      
                    echo '
                    </tbody>
                  </table>';
                }  else if($_GET['search'] == 'courses'){
                  echo '<table id="table" class="table" style="table-layout: auto; overflow-x: scroll;">
                    <thead  class="bg-primary  table-bordered " style="color:white;"> 
                      <tr> 
                        <th colspan="1">Course Name</th>
                      </tr>
                    </thead> 
                    <tbody class=" table-bordered ">'; 
                      $stmt = $db->prepare("SELECT * FROM  course");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      while ($value = $result->fetch_assoc()) {
                         echo '<tr><td>'.$value['course_name'].'</td></tr>';
                      }
                      
                    echo '
                    </tbody>
                  </table>';
                }
                else if($_GET['search'] == 'departments'){
                  echo '<table id="table" class="table" style="table-layout: auto; overflow-x: scroll;">
                    <thead  class="bg-primary  table-bordered " style="color:white;"> 
                      <tr> 
                        <th colspan="1">Department Name</th>
                      </tr>
                    </thead> 
                    <tbody class=" table-bordered ">'; 
                      $stmt = $db->prepare("SELECT * FROM  department");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      while ($value = $result->fetch_assoc()) {
                         echo '<tr><td>'.$value['department_name'].'</td></tr>';
                      }
                      
                    echo '
                    </tbody>
                  </table>';
                }


              ?>

          </div>

          

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
