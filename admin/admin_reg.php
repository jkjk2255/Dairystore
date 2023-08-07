<?php
    include('../includes/connect.php');
    include('../functions/common_functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <!-- Bootstrap  -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

<!-- link css-->
<link rel="stylesheet" href="style.css">
</head>
<body>
<section class="vh-100 bg-image"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Admin Registration</h2>

              <form action="" method="post" enctype="multipart/form-data">
    <div class="form-outline mb-4">
        <label class="form-label" for="username">Your Name</label>
        <input type="text" id="username" name="admin_name" class="form-control form-control-lg" />
    </div>

    <div class="form-outline mb-4">
        <label class="form-label" for="email">Your Email</label>
        <input type="email" id="email" name="admin_email" class="form-control form-control-lg" />
    </div>

    <div class="form-outline mb-4">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="admin_password" class="form-control form-control-lg" />
    </div>

    <div class="form-outline mb-4">
        <label class="form-label" for="confirm_password">Repeat your password</label>
        <input type="password" id="confirm_password" name="confirm_admin_password" class="form-control form-control-lg" />
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" name="admin_reg" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
    </div>

    <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="admin_login.php" class="fw-bold text-body"><u>Login here</u></a></p>
</form>

        </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>


<!-- php code -->

<?php
    if(isset($_POST['admin_reg'])){
        $admin_name = $_POST['admin_name'];
        $admin_email = $_POST['admin_email'];
        $admin_password = $_POST['admin_password'];
        $confirm_admin_password = $_POST['confirm_admin_password'];

        // Check if passwords match
        if($admin_password != $confirm_admin_password){
            echo "<script>alert('Passwords Don't Match')</script>";
        } else {
            // Select query
            $select_query = "SELECT * FROM `admin` WHERE admin_name='$admin_name' OR admin_email='$admin_email'";
            $result_query = mysqli_query($con, $select_query);
            $rows_count = mysqli_num_rows($result_query);
            if($rows_count > 0){
                echo "<script>alert('Username or Email Already Exists')</script>";
            } else {
                // Hash the password
                $hash_password = password_hash($admin_password, PASSWORD_DEFAULT);

                // Insert query using prepared statement
                $insert_query = "INSERT INTO `admin` (admin_name, admin_email, admin_password) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($con, $insert_query);
                mysqli_stmt_bind_param($stmt, "sss", $admin_name, $admin_email, $hash_password);
                $sql_execute = mysqli_stmt_execute($stmt);

                if ($sql_execute) {
                    echo "<script>alert('Registration Successful')</script>";
                } else {
                    die(mysqli_error($con));
                }
            }
        }
    }
?>


