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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon">
         <img class="img-profile"  style="height: 5vh;" src="img/test2.png">
        </div>
        <div class="sidebar-brand-text mx-3"><img class="img-profile"  style="height: 4vh; margin-left: -1vw; margin-right: -1vw" src="img/test3.png"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard Student</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        MAIN NAVIGATION
      </div>
      <li class="nav-item active">
        <a class="nav-link " href="viewScheduleStudent.php">
         <i class="fas fa-fw fa-cog"></i>
          <span>View schedule</span></a>
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

          <?php echo "<input type='hidden' id='teacher' value='".$_SESSION['user_id']."' >" ?>

          <!-- Content Row -->
          <div  class="row">
            <table id="table" class="table  table-bordered " style="table-layout: auto">
              <thead  class="bg-primary" style="color:white;"> 
                <tr> 
                  <th colspan="2">Time</th>
                  <th colspan="5">Days </th>
                </tr>
                <tr>
                  <td colspan="2"></td> 
                  <td>Monday</td> 
                  <td>Tuesday</td> 
                  <td>Wednesday</td> 
                  <td>Thursday</td> 
                  <td>Friday</td> 
                </tr>
              </thead> 
              <tbody> 
                <tr>
                  <td>7:00</td><td>7:30</td><td id="monday-1"></td><td id="tuesday-1"></td><td id="wednesday-1"></td><td id="thursday-1"></td><td id="friday-1"></td>
                </tr> 
                <tr>
                  <td>7:30</td><td>8:00</td><td id="monday-2"></td><td id="tuesday-2"></td><td id="wednesday-2"></td><td id="thursday-2"></td><td id="friday-2"></td>
                </tr> 
                <tr>
                  <td>8:00</td><td>8:30</td><td id="monday-3"></td><td id="tuesday-3"></td><td id="wednesday-3"></td><td id="thursday-3"></td><td id="friday-3"></td>
                </tr> 
                <tr>
                  <td>8:30</td><td>9:00</td><td id="monday-4"></td><td id="tuesday-4"></td><td id="wednesday-4"></td><td id="thursday-4"></td><td id="friday-4"></td>
                </tr> 
                <tr>
                  <td>9:00</td><td>9:30</td><td id="monday-5"></td><td id="tuesday-5"></td><td id="wednesday-5"></td><td id="thursday-5"></td><td id="friday-5"></td>
                </tr> 
                <tr>
                  <td>9:30</td><td>10:00</td><td id="monday-6"></td><td id="tuesday-6"></td><td id="wednesday-6"></td><td id="thursday-6"></td><td id="friday-6"></td>
                </tr> 
                <tr>
                  <td>10:00</td><td>10:30</td><td id="monday-7"></td><td id="tuesday-7"></td><td id="wednesday-7"></td><td id="thursday-7"></td><td id="friday-7"></td>
                </tr> 
                <tr>
                  <td>10:30</td><td>11:00</td><td id="monday-8"></td><td id="tuesday-8"></td><td id="wednesday-8"></td><td id="thursday-8"></td><td id="friday-8"></td>
                </tr> 
                <tr>
                  <td>11:00</td><td>11:30</td><td id="monday-9"></td><td id="tuesday-9"></td><td id="wednesday-9"></td><td id="thursday-9"></td><td id="friday-9"></td>
                </tr>
                <tr>
                  <td>11:30</td><td>12:00</td><td id="monday-10"></td><td id="tuesday-10"></td><td id="wednesday-10"></td><td id="thursday-10"></td><td id="friday-10"></td>
                </tr> 
                <tr>
                  <td>12:00</td><td>12:30</td><td id="monday-11"></td><td id="tuesday-11"></td><td id="wednesday-11"></td><td id="thursday-11"></td><td id="friday-11"></td>
                </tr> 
                <tr>
                  <td>12:30</td><td>1:00</td><td id="monday-12"></td><td id="tuesday-12"></td><td id="wednesday-12"></td><td id="thursday-12"></td><td id="friday-12"></td>
                </tr> 
                <tr>
                  <td>1:00</td><td>1:30</td><td id="monday-13"></td><td id="tuesday-13"></td><td id="wednesday-13"></td><td id="thursday-13"></td><td id="friday-13"></td>
                </tr> 
                <tr>
                  <td>1:30</td><td>2:00</td><td id="monday-14"></td><td id="tuesday-14"></td><td id="wednesday-14"></td><td id="thursday-14"></td><td id="friday-14"></td>
                </tr> 
                <tr>
                  <td>2:00</td><td>2:30</td><td id="monday-15"></td><td id="tuesday-15"></td><td id="wednesday-15"></td><td id="thursday-15"></td><td id="friday-15"></td>
                </tr>
                <tr>
                  <td>2:30</td><td>3:00</td><td id="monday-16"></td><td id="tuesday-16"></td><td id="wednesday-16"></td><td id="thursday-16"></td><td id="friday-16"></td>
                </tr> 
                <tr>
                  <td>3:00</td><td>3:30</td><td id="monday-17"></td><td id="tuesday-17"></td><td id="wednesday-17"></td><td id="thursday-17"></td><td id="friday-17"></td>
                </tr> 
                <tr>
                  <td>3:30</td><td>4:00</td><td id="monday-18"></td><td id="tuesday-18"></td><td id="wednesday-18"></td><td id="thursday-18"></td><td id="friday-18"></td>
                </tr> 
                <tr>
                  <td>4:00</td><td>4:30</td><td id="monday-19"></td><td id="tuesday-19"></td><td id="wednesday-19"></td><td id="thursday-19"></td><td id="friday-19"></td>
                </tr>
                <tr>
                  <td>4:30</td><td>5:00</td><td id="monday-20"></td><td id="tuesday-20"></td><td id="wednesday-20"></td><td id="thursday-20"></td><td id="friday-20"></td>
                </tr> 
                <tr>
                  <td>5:00</td><td>5:30</td><td id="monday-21"></td><td id="tuesday-21"></td><td id="wednesday-21"></td><td id="thursday-21"></td><td id="friday-21"></td>
                </tr> 
                <tr>
                  <td>5:30</td><td>6:00</td><td id="monday-22"></td><td id="tuesday-22"></td><td id="wednesday-22"></td><td id="thursday-22"></td><td id="friday-22"></td>
                </tr> 
                <tr>
                  <td>6:00</td><td>6:30</td><td id="monday-23"></td><td id="tuesday-23"></td><td id="wednesday-23"></td><td id="thursday-23"></td><td id="friday-23"></td>
                </tr> 
                <tr>
                  <td>6:30</td><td>7:00</td><td id="monday-24"></td><td id="tuesday-24"></td><td id="wednesday-24"></td><td id="thursday-24"></td><td id="friday-24"></td>
                </tr> 
                <tr>
                  <td>7:00</td><td>7:30</td><td id="monday-25"></td><td id="tuesday-25"></td><td id="wednesday-25"></td><td id="thursday-25"></td><td id="friday-25"></td>
                </tr>
                <tr>
                  <td>7:30</td><td>8:00</td><td id="monday-26"></td><td id="tuesday-26"></td><td id="wednesday-26"></td><td id="thursday-26"></td><td id="friday-26"></td>
                </tr> 
                <tr>
                  <td>8:00</td><td>8:30</td><td id="monday-27"></td><td id="tuesday-27"></td><td id="wednesday-27"></td><td id="thursday-27"></td><td id="friday-27"></td>
                </tr> 
                <tr>
                  <td>8:30</td><td>9:00</td><td id="monday-28"></td><td id="tuesday-28"></td><td id="wednesday-28"></td><td id="thursday-28"></td><td id="friday-28"></td>
                </tr> 
              </tbody>
            </table>
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

  <script type="text/javascript">
        var teacher = $('#teacher').val();
        $.ajax({
          type: "POST",
          url: "php/request.php",
          data: { action: "getScheduleTeacher",
                   teacher: teacher},
          success: function(response) {
              var obj = JSON.parse(response);
              console.log(obj);
               obj.forEach(el => {
                  el.time.forEach(time =>{
                     $('#'+el.day+"-"+time.time_id).css("background", el.color);
                     $('#'+el.day+"-"+time.time_id).css("color", "black");
                     $('#'+el.day+"-"+time.time_id).html(el.subject+"<br>"+el.classType+"<br>"+el.room);

                  });
                   var count = el.time.length;

                   $('#'+el.day+"-"+el.time[0].time_id).attr("rowspan", count);

                   for (var i = 1; i < count ; i++) {
                     $('#'+el.day+"-"+(el.time[0].time_id+i)).remove();
                   }

               });

            }
          
        });
  
  </script>

</body>

</html>
