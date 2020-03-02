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

<body class="bg-gradient-primary">

	<?php
		include 'php/db.php';
		session_start();

		$error = '';

		if(isset($_POST['submit'])){
			  $stmt = $db->prepare("SELECT * FROM  user WHERE email = ?");
		      $stmt->bind_param("s",$_POST['email']);
		      $stmt->execute();
		      $result = $stmt->get_result();

		      if ($result->num_rows > 0) {
		      	$result = $result->fetch_assoc();
		      	  if(password_verify($_POST['password'], $result['password'])){
		      	  	if($result['type'] == 1){
		      	  		$_SESSION['id'] = $result['id'];
		      	  		header("location:dashboard.php");
		      	  	}elseif($result['type'] == 2){
		      	  		$_SESSION['id'] = $result['id'];
		      	  		header("location:dashboardTeacher.php");
		      	  	}elseif($result['type'] == 3){
		      	  		$_SESSION['id'] = $result['id'];
		      	  		header("location:dashboardDPD.php");
		      	  	}
		      	  }else{
		      	  	$error = "<div class='alert alert-danger' role='alert'>
                      Incorrect password.
                    </div>";
		      	  }
		      }else{
		      	$error = "<div class='alert alert-danger' role='alert'>
                      No account with such email.
                    </div>";
		      }
		}

	?>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                   <?php
	                echo $error;
	              ?>
                  <form class="user" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" name="submit" value="Submit">                 
                   
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.php">Create an Account!</a>
                  </div>
                </div>
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

</body>

</html>
