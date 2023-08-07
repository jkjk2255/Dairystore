<?php
    include('../includes/connect.php');
    include('../functions/common_functions.php');
    @session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
              <h2 class="text-uppercase text-center mb-5">Admin Login</h2>

              <form action="" method="post">

                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example1cg">Username</label>
                  <input type="text" id="admin_name" name="admin_name" class="form-control form-control-lg" />
                  
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example4cg">Password</label>
                  <input type="password" id="admin_password" name="admin_password" class="form-control form-control-lg" />
                  
                </div>

                <div class="d-flex justify-content-center">
        <button type="submit" name="admin_login" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login</button>
    </div>

                <p class="text-center text-muted mt-5 mb-0">Don't have an account? <a href="admin_reg.php"
                    class="fw-bold text-body"><u>Register here</u></a></p>
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




<?php
if (isset($_POST['admin_login'])) {
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];

    $select_query = "SELECT * FROM `admin` WHERE admin_name='$admin_name'";
    $result_query = mysqli_query($con, $select_query);
    $row_count = mysqli_num_rows($result_query);
    $row_data = mysqli_fetch_assoc($result_query);

    if ($row_count > 0) {
        $_SESSION['admin_name'] = $admin_name;
        if (password_verify($admin_password, $row_data['admin_password'])) {
          //echo "<script>alert('Login Successful')</script>";
          if ($row_count == 1) {
            $_SESSION['admin_name'] = $admin_name;
            echo "<script>alert('Login Successful')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }else
        echo "<script>alert('Invalid Credentials')</script>";
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
}
?>
<?php
  include("../includes/footer.php")

?>