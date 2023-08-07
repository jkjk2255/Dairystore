<?php
    include('../includes/connect.php');
    include('../functions/common_functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User_reg</title>
<!-- Bootstrap  -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

<!-- link css-->
<link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">New User Registration</h2>
        <br>
        <br>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline mb-4">
                        <!-- username -->
                        <label for="user_username" class="form-label">User Name</label>
                        <input type="text" id="user_username" class="form-control" 
                        placeholder="Enter Your Username" autocomplete="off" required="required" name="user_username"/>
                        </div>
                        <!--email -->
                        <div class="form-outline mb-4">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" id="user_email" class="form-control" 
                        placeholder="Enter Your Email" autocomplete="off" required="required" name="user_email"/>
                        </div>
                        <!--image -->
                        <div class="form-outline mb-4">
                        <label for="user_image" class="form-label">User Image</label>
                        <input type="file" id="user_image" class="form-control" 
                         required="required" name="user_image"/>
                        </div>
                        <!--password -->
                        <div class="form-outline mb-4">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" id="user_password" class="form-control" 
                        placeholder="Enter Your Password" autocomplete="off" required="required" name="user_password"/>
                        </div>
                        <!--confirm password -->
                        <div class="form-outline mb-4">
                        <label for="confirm_user_password" class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_user_password" class="form-control" 
                        placeholder="Confirm Password" autocomplete="off" required="required" name="confirm_user_password"/>
                        </div>
                        <!-- address -->
                        <div class="form-outline mb-4">
                        <label for="user_address" class="form-label">Address</label>
                        <input type="text" id="user_address" class="form-control" 
                        placeholder="Enter Your Address" autocomplete="off" required="required" name="user_address"/>
                        </div>
                        <!-- contact -->
                        <div class="form-outline mb-4">
                        <label for="user_contact" class="form-label">Contact</label>
                        <input type="text" id="user_contact" class="form-control" 
                        placeholder="Enter Your Mobile Number" autocomplete="off" required="required" name="user_contact"/>
                        </div>
                        <div class="mt-4 pt-2">
                            <input type="submit" value="Register" class="bg-info py-2 px-3 border-0" name="user_register"> 
                            <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account?  <a href="user_login.php"
                            class="text-danger"> Login</a></p>
                        </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!-- php code -->

<?php
    if(isset($_POST['user_register'])){
        $user_username = $_POST['user_username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $hash_password = password_hash($user_password,PASSWORD_DEFAULT);
        $confirm_user_password = $_POST['confirm_user_password'];
        $user_address = $_POST['user_address'];
        $user_contact = $_POST['user_contact'];
        $user_image = $_FILES['user_image']['name'];
        $user_image_tmp = $_FILES['user_image']['tmp_name'];
        $user_ip = getIPAddress();

        //select query

        $select_query = "Select * from `user_table` where username='$user_username' or user_email='$user_email'";
        $result_query = mysqli_query($con , $select_query);
        $rows_count = mysqli_num_rows($result_query);
        if($rows_count>0){
            echo "<script>alert('Username or Email Already Exists')</script>";
        } else if($user_password!=$confirm_user_password){
            echo "<script>alert('Passwords Donot Match')</script>";
        }
        
        else{   //insert query
            move_uploaded_file($user_image_tmp, "./user_images/$user_image");
        $insert_query = "INSERT INTO `user_table` (username, user_email, user_password, user_image, user_ip, user_address, user_mobile) 
        VALUES ('$user_username','$user_email','$hash_password','$user_image','$user_ip','$user_address','$user_contact')";
        $sql_execute = mysqli_query($con, $insert_query);

        if ($sql_execute) {
            echo "<script>alert('Registration Successful')</script>";
        } else {
            die(mysqli_error($con));
         }
            }

            //selecting cart items

            $select_cart_items = "Select * from `cart_details` where 
            ip_address='$user_ip'";
            $result_cart = mysqli_query($con,$select_cart_items);
            $rows_count = mysqli_num_rows($result_cart);
            if($rows_count>0){
                $_SESSION['username'] = $user_username;
                echo "<script>alert('You Have Items In Your Cart')</script>";
                echo "<script>window.open('checkout.php','_SELF')</script>";
             } else{
                echo "<script>window.open('../index.php','_SELF')</script>";
            } 
    }
?>

<!-- include footer -->

<?php
  include("../includes/footer.php")

?>
