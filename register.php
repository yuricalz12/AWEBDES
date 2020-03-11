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

<?php

    include 'php/db.php';
    $error = '';

    if(isset($_POST['submit'])){
      $email = $db->real_escape_string($_POST['email']);
      $password = password_hash($db->real_escape_string($_POST['password']), PASSWORD_BCRYPT );
      $confirmPassword = $db->real_escape_string($_POST['confirmPassword']);
      $firstName = $db->real_escape_string($_POST['firstName']);
      $lastName = $db->real_escape_string($_POST['lastName']);
      $department = $db->real_escape_string($_POST['department']);
      $type = $db->real_escape_string($_POST['type']);
      $course = $db->real_escape_string($_POST['course']);
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
                header('location: index.php');
             }
          }
        }
      } 
      
    }

?>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <?php
                echo $error;
              ?>
              <form class="user" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" name="firstName" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="lastName"  class="form-control form-control-user" id="exampleLastName" placeholder="Last Name">
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" name="email"  class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" name="password"  class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" name="confirmPassword"  class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" name="address"  class="form-control form-control-user" id="exampleInputAddress" placeholder="Address">
                </div>
                <div class="form-group row">
                  <div  class="col-sm-6 mb-3 mb-sm-0">
                    <input name="dob" class="form-control form-control-user"  type="date" name="dob">
                  </div>

                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <select name="gender"  class="form-control " name="type" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh">
                      <option value="" disabled selected>Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
      
                </div>
                <div class="form-group row">
                   <div class="col-sm-6 mb-3 mb-sm-0">
                    <select id="type" name="type"  class="form-control " name="type" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh">
                      <option value="0" disabled selected>Type of User</option>
                      <option value="1">Student</option>
                      <option value="2">Teacher</option>
                      <option value="3">DPD</option>
                    </select>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <select name="department"  class="form-control " name="department" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh">
                      <option value="0" disabled selected>Department</option>
                      <option value="1">department1</option>
                      <option value="2">department2</option>
                      <option value="3">department3</option>
                    </select>
                  </div>

                </div>
                 <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <select id="course" name="course"  class="form-control" name="course" style="font-size: 0.8rem;border-radius: 10rem;height: 5vh; display: none;">
                      <option value="0" disabled selected="selected">Course</option>
                      <option value="1">Course1</option>
                      <option value="2">Course2</option>
                      <option value="3">Course3</option>
                    </select>
                  </div>
                 </div>
                
                <input class="btn btn-primary btn-user btn-block" type="submit" name="submit" value="Register Account">
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.html">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="index.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
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
      $("#type").on('change', function() {
        if($("#type").val() == 1){
          $("#course").css("display", "block");
        }else{
          $("#course").css("display", "none");
        }
      });
  </script>

</body>

</html>
