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
  <link href="css/bootstrap-multiselect.css" rel="stylesheet">
  
</head>

<body id="page-top" >

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
      <li class="nav-item active">
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
          <h1 class="h3 mb-2 text-gray-800">Schedule to multiple students</h1>

          <div id="alertContainer">
            
          </div>
          <!-- Content Row -->
            
            
            <div id="inputContainer" class="row">
               <div class="col-md-2 col-sm-3 mb-1 mb-sm-0">
                  <?php 
                      $stmt = $db->prepare("SELECT DISTINCT section_id from section_schedule");
                      $stmt->execute();
                      $info = $stmt->get_result();
                      echo '<select id="section" class="form-control " name="section" style="font-size: 0.8rem;height: 5vh;border-radius: 10rem; background:white;">
                      <option disabled selected="selected">Section Name</option>';
                       while ($value = $info->fetch_assoc()) {
                            $stmt = $db->prepare("SELECT * FROM  section WHERE section_id = ?");
                            $stmt->bind_param("s",$value['section_id']);
                            $stmt->execute();
                            $user = $stmt->get_result()->fetch_assoc();
                            echo "<option value=".$value['section_id']." >".$user['section_name']."</option>";
                        }
                      
                         echo '</select>';
                      
                  ?>

                </div>

                <div class="col-sm-2 mb-1 mb-sm-0">
                     <?php 
                      $stmt4 = $db->prepare("SELECT DISTINCT user_id FROM schedule");
                      $stmt4->execute();
                      $result = $stmt4->get_result();
                      if($result->num_rows == 0){
                          $stmt2 = $db->prepare("SELECT * FROM  user WHERE user_type = 1");
                          $stmt2->execute();
                          $info = $stmt2->get_result();
                          echo '<select id="students" class="form-control " multiple="multiple" name="students" style="font-size: 0.8rem;height: 5vh; background:white;">';
                           while ($value2 = $info->fetch_assoc()) {
                                $stmt3 = $db->prepare("SELECT * FROM  user_information WHERE user_id = ?");
                                $stmt3->bind_param("s",$value2['user_id']);
                                $stmt3->execute();
                                $user = $stmt3->get_result()->fetch_assoc();
                                echo "<option value=".$value2['user_id']." >".$user['info_first_name']."</option>";
                            }
                          
                             echo '</select>';
                      }else{
                        while($value3 = $result->fetch_assoc()){
                         $filter[] = $value3['user_id'];
                        }
                        $searchID = implode(',', $filter);

                        $stmt2 = $db->prepare("SELECT * FROM  user WHERE user_id NOT IN (".$searchID.") AND user_type = 1");
                        $stmt2->execute();
                        $info = $stmt2->get_result();
                        echo '<select id="students" class="form-control " multiple="multiple" name="students" style="font-size: 0.8rem;height: 5vh; background:white;">';
                         while ($value2 = $info->fetch_assoc()) {
                              $stmt3 = $db->prepare("SELECT * FROM  user_information WHERE user_id = ?");
                              $stmt3->bind_param("s",$value2['user_id']);
                              $stmt3->execute();
                              $user = $stmt3->get_result()->fetch_assoc();
                              echo "<option value=".$value2['user_id']." >".$user['info_first_name']."</option>";
                          }
                        
                           echo '</select>';
                      }
                      
                      
                  ?>
                </div>
                <div class="col-sm-2 mb-1 mb-sm-0">
                  <input id="submit" class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="Submit">
                </div>
            </div>
   

          <div  class="row">
            <div class="col-md-10 ">
              
            <table id="table" class="table" style="display:none;table-layout: auto; overflow-x: scroll;">
              <thead  class="bg-primary  table-bordered " style="color:white;"> 
                <tr> 
                  <th colspan="2">Time</th>
                  <th colspan="5">Days </th>
                </tr>
                <tr>
                  <th colspan="2"></th> 
                  <th style="width: 15vh">Monday</th> 
                  <th style="width: 15vh">Tuesday</th> 
                  <th style="width: 15vh">Wednesday</th> 
                  <th style="width: 15vh">Thursday</th> 
                  <th style="width: 15vh">Friday</th> 
                </tr>
              </thead> 
              <tbody class=" table-bordered "> 
                <tr>
                  <td>7:00</td><td>7:30</td><td id="monday-1" ></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>7:30</td><td>8:00</td><td id="monday-2"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>8:00</td><td>8:30</td><td id="monday-3"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>8:30</td><td>9:00</td><td id="monday-4"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>9:00</td><td>9:30</td><td id="monday-5"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>9:30</td><td>10:00</td><td id="monday-6"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>10:00</td><td>10:30</td><td id="monday-7"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>10:30</td><td>11:00</td><td id="monday-8"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>11:00</td><td>11:30</td><td id="monday-9"></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <td>11:30</td><td>12:00</td><td id="monday-10"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>12:00</td><td>12:30</td><td id="monday-11"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>12:30</td><td>1:00</td><td id="monday-12"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>1:00</td><td>1:30</td><td id="monday-13"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>1:30</td><td>2:00</td><td id="monday-14"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>2:00</td><td>2:30</td><td id="monday-15"></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <td>2:30</td><td>3:00</td><td id="monday-16"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>3:00</td><td>3:30</td><td id="monday-17"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>3:30</td><td>4:00</td><td id="monday-18"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>4:00</td><td>4:30</td><td id="monday-19"></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <td>4:30</td><td>5:00</td><td id="monday-20"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>5:00</td><td>5:30</td><td id="monday-21"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>5:30</td><td>6:00</td><td id="monday-22"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>6:00</td><td>6:30</td><td id="monday-23"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>6:30</td><td>7:00</td><td id="monday-24"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>7:00</td><td>7:30</td><td id="monday-25"></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <td>7:30</td><td>8:00</td><td id="monday-26"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>8:00</td><td>8:30</td><td id="monday-27"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>8:30</td><td>9:00</td><td id="monday-28"></td><td></td><td></td><td></td><td></td>
                </tr> 
              </tbody>
            </table>

            </div>
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
  <script src="js/bootstrap-multiselect.js"></script>

 

  <script type="text/javascript">
    $(document).ready(function() {
        $('#students').multiselect();
      });
     
      $('#students').on('change',function(){
            console.log( $('#students').val());
        });

   
    $('#section').on('change',function(){
        var section = $('#section').val();
        $.ajax({
          type: "POST",
          url: "php/request.php",
          data: { action: "getSectionSchedule",
                   section: section},
          beforeSend: function(){
            tableReset(); 
          },
          success: function(response) {
              console.log(response);

              if(response == 0){
                $('#table').css('display', 'none');
                $('#alertContainer').html("<div class='alert alert-danger alert-dismissible' role='alert' ><strong>No schedule<button type='button' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times;</span></button></div>");
              }else{
                 $('#table').css('display', 'block');
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
              

            }
          
        });
    }); 
    function tableReset(){
      $.ajax({
          type: "POST",
          url: "php/request.php",
          data: { action: "tableReset"},
          success: function(response){
              $('#table').html(response);
            }
          
        });
    }

    $('#submit').on('click',function(){
        var students = $('#students').val();
        var section = $('#section').val();
        $.ajax({
          type: "POST",
          url: "php/request.php",
          data: { action: "scheduleMultiple",
                  students: students,
                  section: section},
          success: function(response){
              if(response == 0){
                location.reload(true);
              }
            }
          
        });
    });

  </script>
    


</body>

</html>
