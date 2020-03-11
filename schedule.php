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
      <li class="nav-item">
        <a class="nav-link" href="scheduleSection.php">
         <i class="fas fa-fw fa-calendar-plus "></i>
          <span>Schedule Section</span></a>
      </li>
      <li class="nav-item active">
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
      <li class="nav-item ">
        <a class="nav-link" href="profileDPD.php">
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
                $student_id = $_POST['student'];
                $subject = $_POST['subject'];
                $subjectSection =  $_POST['subjectSection'];

                $stmt = $db->prepare("SELECT * FROM section_schedule WHERE section_id = ? AND subject_id = ?");
                $stmt->bind_param('ii', $subjectSection, $subject);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($schedule = $result->fetch_assoc()) {
                   $stmt2 = $db->prepare("INSERT INTO schedule (subject_id, room_id, user_id, dpd_id, class_type, day, start_time_id, end_time_id) VALUES (?,?,?,?,?,?,?,?)");
                   $stmt2->bind_param("iiiissii", $schedule['subject_id'], $schedule['room_id'], $student_id, $schedule['dpd_id'], $schedule['class_type'], $schedule['day'], $schedule['start_time_id'], $schedule['end_time_id']);
                   if($stmt2->execute()){
                         $success = true;
                   }else{
                     
                    }    
                }
                
                

              }


              echo "<div class='alert alert-success alert-dismissible' role='alert' ><strong>Successfuly scheduled<button type='button' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times;</span></button></div>";
                
             ?>

          <div id="alertContainer">
            
          </div>
          <!-- Content Row -->
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            
            <br>
            <div id="inputContainer" class="row">
               <div class="col-md-2 col-sm-3 mb-1 mb-sm-0">
                  <?php 
                     $stmt2 = $db->prepare("SELECT * FROM  user WHERE user_type = 1");
                          $stmt2->execute();
                          $info = $stmt2->get_result();
                           echo '<select id="student" class="form-control " name="student" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh">
                            <option disabled selected="selected">Student Name</option>';
                           while ($value2 = $info->fetch_assoc()) {
                                $stmt3 = $db->prepare("SELECT * FROM  user_information WHERE user_id = ?");
                                $stmt3->bind_param("s",$value2['user_id']);
                                $stmt3->execute();
                                $user = $stmt3->get_result()->fetch_assoc();
                                echo "<option value=".$value2['user_id']." >".$user['info_first_name']." ".$user['info_last_name']."</option>";
                            }
                          
                             echo '</select>';
                      
                  ?>

                </div>

                <div class="col-sm-2 mb-1 mb-sm-0">
                  <select id="subject" class="form-control " name="subject" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh; display:none; margin-bottom: 1vh">
                    <option disabled selected="selected">Subject Name</option>
                  </select>
                </div>
                <div class="col-sm-2 mb-1 mb-sm-0">
                  <select id="subjectSection" class="form-control" name="subjectSection" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh; display:none; margin-bottom: 1vh">
                    <option disabled selected="selected">Section</option>
                  </select>
                </div>
                <div class="col-sm-2 mb-1 mb-sm-0">
                  <input id="submit" class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="Submit" style="display:none;">
                </div>
            </div>
         </form>
         <br>
          <div  class="row" id="tableContainer">
           <table id="table" class="table  table-bordered " style="table-layout: auto;display: none; ">
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

 

  <script type="text/javascript">
      
    $('#student').on('change',function(){
        var student = $('#student').val();
        $.ajax({
          type: "POST",
          url: "php/request.php",
          data: { action: "getStudentSubject",
                  student: student },
          success: function(response) {
            console.log(response);
              $('#subject').html(response);
              $('#subject').css('display', 'block');
              $('#table').css('display', 'block');

              $('#submit').css('display', 'none');

              

            
          }
        });
    });


     $('#inputContainer').on('change', '#subject', function() {
        var subject = $('#subject').val();
         var student = $('#student').val();
        console.log(subject); 
        $.ajax({
           type: "POST",
           url: "php/request.php",
           data: { action: "getSubjectSection",
                   subject: subject,
                   student: student },
           success: function(response) {
              console.log(response);
                if(response == 0){
                  $('#alertContainer').html("<div class='alert alert-danger alert-dismissible' role='alert' ><strong>All section will conflict the existing schedule<button type='button' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times;</span></button></div>");
                }else{
                   $('#subjectSection').html(response);
                   $('#subjectSection').css('display', 'block');  

                   $('#submit').css('display', 'none');
                }
               
            }
           });

    }); 


     $('#inputContainer').on('change', '#subjectSection', function() {
        
        $('#submit').css('display', 'block');
    }); 



    $('#student').on('change',function(){
        var student = $('#student').val();
        $.ajax({
          type: "POST",
          url: "php/request.php",
          data: { action: "getSchedule",
                   student: student},
          beforeSend: function(){
            tableReset(); 
          },
          success: function(response) {
              console.log(response);

              if(response == 0){
                $('#table').css('display', 'none');
                $('#alertContainer').html("<div class='alert alert-danger alert-dismissible' role='alert' ><strong>No schedule<button type='button' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times;</span></button></div>");
              }else{
                setTimeout(function(){
                    var obj = JSON.parse(response);
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
                }, 1500)
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
              $('#tableContainer').html(response);
            }
          
        });
    }

   

  </script>
    


</body>

</html>
