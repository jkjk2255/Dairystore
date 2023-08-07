<!-- COnnect -->
<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $_SESSION['username']?></title>
    <!-- Bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link css-->
    <link rel="stylesheet" href="../style.css">
    <style>
    .logo{
        width: 7%;
        height: 7%;
    }
    .profile_img{
        width: 90%;
       /* height: 100%; */
        margin: auto;
        display: block;
        object-fit: contain;
    }

    

    </style>
     
</head>
<body>


    <!-- navbar-->


    <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-info">
        <div class="container-fluid">
            <img src="../images/logo3.png" alt="" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../display_all.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Total Price: <?php total_cart_price();?>/-</a>
                    </li>
                    <?php
                        if(isset($_SESSION['username'])){
                            echo "<li class='nav-item'>
                            <a class='nav-link' href='user_areaprofile.php'>My Account</a>
                          </li>";
                        }
                    ?>
                </ul>

               

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../cart.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <sup><?php cart_item();?></sup>
                        </a>
                    </li>
                    
                    
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">My Account</a>
                    </li>
                    <?php
          if(!isset($_SESSION['username'])){
            echo "<li class='nav-item'>
            <a class='nav-link' href='user_login.php'>Login</a>
          </li>";
          }else {
            echo "<li class='nav-item'>
            <a class='nav-link' href='logout.php'>Logout</a>
          </li>";
          }
      ?>
                </ul>
            </div>
        </div>
    </nav>
</div>




<!-- additional horizontal navbar -->
<nav class="navbar navbar-expand-lg bg-secondary">
<!--  <div class="container-fluid"> -->
    <!-- Left-aligned element -->
 <!--   <span class="navbar-text"> -->
    <ul class="navbar-nav me-auto">
    <?php
if (isset($_SESSION['username'])) {
    echo "<li class='nav-item'>
            <a class='nav-link' href='#'>Welcome ".$_SESSION['username']."</a>
          </li>";
} else {
    echo "<li class='nav-item'>
            <a class='nav-link' href='#'>Welcome Guest</a>
          </li>";
}
?>

    </ul>
  <!--    Welcome Guest -->
  <!--  </span> -->

    
  </div>
</nav>



<!-- calling cart function -->
<?php
  cart();
?>


 


  <div class="row">
    <div class="col-md-2">
    <ul class="navbar-nav bg-secondary text-center" style="height:100vh">
        <li class="nav-item bg-info">
             <a class="nav-link text-light" href="#"><h4>Your Profile</h4></a>
        </li>

        <?php
            $username = $_SESSION['username'];
            $user_image = "Select * from `user_table` where 
            username='$username'";
            $user_image = mysqli_query($con , $user_image);
            $row_image = mysqli_fetch_array($user_image);
            $user_image = $row_image['user_image'];
            echo "<li class='nav-item'>
            <img src='user_images/$user_image' class='profile_img my-2' alt=''>
       </li>";
        ?>

 
        <li class="nav-item">
             <a class="nav-link text-light" href="profile.php">Pending Orders</a>
        </li>
        <li class="nav-item">
             <a class="nav-link text-light" href="profile.php?edit_account">
                Edit Account</a>
        </li>
        <li class="nav-item">
             <a class="nav-link text-light" href="profile.php?my_orders">
                My Orders</a>
        </li>
        <li class="nav-item">
             <a class="nav-link text-light" href="profile.php?delete_account">
                Delete Account</a>
        </li>
    </ul>
    </div> 
    <div class="col-md-10 text-center">
        <?php get_user_order_details(); 
        if(isset($_GET['edit_account'])){
            include('edit_account.php');
        }
        if(isset($_GET['my_orders'])){
            include('user_orders.php');
        }
        if(isset($_GET['delete_account'])){
            include('delete_account.php');
        }
        ?>
    
    </div>
  </div>

  



<!-- include footer -->

<?php
  include("../includes/footer.php")

?>

   </div>


    </div>

   

<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>



</body>
</html>


