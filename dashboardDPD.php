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
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
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
        <a class="nav-link" href="schedule.php">
         <i class="fas fa-fw fa-calendar-plus "></i>
          <span>Schedule Student</span></a>
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
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>
          <!-- Content Row -->
          <div id="alertContainer">
            
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-3 mb-1 mb-sm-0">
                <?php 
                      $stmt = $db->prepare("SELECT * FROM  course");
                      $stmt->execute();
                      $info = $stmt->get_result();
                      echo '<select id="course" class="form-control " name="course" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh">
                        ';
                       while ($value = $info->fetch_assoc()) {
                            echo "<option value=".$value['course_id']." >".$value['course_name']."</option>";
                        }
                      
                         echo '</select>';
                  ?>
            </div>
            <div class="col-md-2 col-sm-3 mb-1 mb-sm-0">
                <select id="year" class="form-control " name="year" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh">
                  <option value="1">First Year</option>
                  <option value="2">Second Year</option>
                  <option value="3">Third Year</option>
                  <option value="4">Fourth Year</option>
                  <option value="5">Fifth Year</option>
                </select>
           </div>
           <div class="col-md-2 col-sm-3 mb-1 mb-sm-0">
                <select id="semester" class="form-control " name="semester" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh">
                  <option value="1">First Semester</option>
                  <option value="2">Second Semester</option>
                </select>
           </div>


            </div>
            <br>
            <div class="row">
                <div id="chartDiv">
                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                    </div>
                    <div class="card-body">
                      <div class="chart-bar">
                        <canvas id="subjectStats"></canvas>
                      </div>
                      <hr>
                      Number of Students per subject.
                    </div>
                  </div>
                </div>
                
            </div>
          </div>

        <!-- /.container-fluid -->

          

        
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
  <script src="vendor/chart.js/Chart.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>


  <script type="text/javascript">

        function getSubjectStats(){
            var course = $('#course').val();
            var year = $('#year').val();
            var semester = $('#semester').val();
            var subjectName = [];
            var studentCount = [];
            $.ajax({
              type: "POST",
              url: "php/request.php",
              data: { action: "getSubjectStatistic",
                      course: course,
                      year: year,
                      semester: semester},
              success: function(response) {
                if(response != 0){
                   var obj = JSON.parse(response);
                  
                  console.log(obj);
                   obj.forEach(el => {

                      subjectName.push(el.subject);
                      studentCount.push(el.count);

                   });

                    getStats(subjectName, studentCount);
                    $('#chartDiv').css('display', 'block');
                    $('#alert').trigger('click');
                }else{
                    console.log("No subject");
                    $('#chartDiv').css('display', 'none');
                    $('#alertContainer').html("<div  class='alert alert-danger alert-dismissible' role='alert' ><strong>No Subject<button type='button' class='close' data-dismiss='alert' aria-label='close'><span id='alert' aria-hidden='true'>&times;</span></button></div>");
                }
                 

                }
              
            });
        }

        getSubjectStats();

        $('#course').on('change',function(){
          getSubjectStats();
        });
        $('#year').on('change',function(){
          getSubjectStats();
        });
        $('#semester').on('change',function(){
          getSubjectStats();
        });
        
  </script>

   <script src="js/stats.js"></script>

</body>

</html>
