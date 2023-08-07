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
    <title>Admin Dashboard</title>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <!-- css -->
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin_img{
    width: 100px;
    object-fit: contain;
}
.navlink {
    text-decoration: none;
  }
.user_img{
    width: 100px;
    object-fit: contain;
    height: 100px;
}
    </style>

        <!-- font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <!-- Navbar -->
    <div class="container-fluid p-0 ">
        <nav class="navbar navbar-expand-lg  navbar-light bg-info ">
            <div class="container-fluid ">
                <img src="../images/boy.jpeg" alt="" class="logo">
                <nav class="navbar navbar-expand-lg ">

                <div class="button text-center px-3 m-auto ">
                    <button class="my-3" style="font-size: 20px;"><a href="insert_products.php" 
                    class="navlink text-light bg-info my-1">Insert Products</a></button>
                    <button style="font-size: 20px;"><a href="index.php?view_products" 
                    class="navlink text-light  bg-info my-1">View Products</a></button>
                    <button style="font-size: 20px;" ><a href="index.php?insert_category" 
                    class="navlink text-light bg-info my-1">Insert Category</a></button>
                    <button style="font-size: 20px;"><a href="index.php?view_categories" 
                    class="navlink text-light bg-info my-1">View Category</a></button>
                    <button style="font-size: 20px;"><a href="index.php?list_orders" 
                    class="navlink text-light bg-info my-1">All Orders</a></button>
                    <button style="font-size: 20px;"><a href="index.php?list_payments" 
                    class="navlink text-light bg-info my-1">All Payments</a></button>
                    <button style="font-size: 20px;"><a href="index.php?list_users" 
                    class="navlink text-light bg-info my-1">List Users</a></button>
                    <button style="font-size: 20px;"><a href="admin_login.php" 
                    class="navlink text-light bg-info my-1">Logout</a></button>
                </div>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <?php
                                if (isset($_SESSION['admin_name'])) {
                                    echo "<li class='nav-item'>
                                            <a class='nav-link' href='#'>Welcome ".$_SESSION['admin_name']."</a>
                                        </li>";
                                } else {
                                    echo "<li class='nav-item'>
                                            <a class='nav-link' href='#'>Welcome Guest</a>
                                        </li>";
                                }
                                ?>
                        </li>
                    </ul>

                </nav>
            </div>
        </nav>
        
    <!--    <div class="row">
            <div class="col md-12 bg-secondary p-1 d-flex align-items-center">
                <div class="p-3">
                    <a href="#"><img src="../images/boy.jpeg" alt="" class="admin_img"></a>
                    <p class="text-light text-center">Admin</p>
                </div>
            

                <div class="button text-center px-3 m-auto">
                    <button class="my-3" style="font-size: 20px;"><a href="insert_products.php" 
                    class="navlink text-light bg-info my-1">Insert Products</a></button>
                    <button style="font-size: 20px;"><a href="index.php?view_products" 
                    class="navlink text-light  bg-info my-1">View Products</a></button>
                    <button style="font-size: 20px;" ><a href="index.php?insert_category" 
                    class="navlink text-light bg-info my-1">Insert Category</a></button>
                    <button style="font-size: 20px;"><a href="index.php?view_categories" 
                    class="navlink text-light bg-info my-1">View Category</a></button>
                    <button style="font-size: 20px;"><a href="index.php?list_orders" 
                    class="navlink text-light bg-info my-1">All Orders</a></button>
                    <button style="font-size: 20px;"><a href="index.php?list_payments" 
                    class="navlink text-light bg-info my-1">All Payments</a></button>
                    <button style="font-size: 20px;"><a href="index.php?list_users" 
                    class="navlink text-light bg-info my-1">List Users</a></button>
                    <button style="font-size: 20px;"><a href="" 
                    class="navlink text-light bg-info my-1">Logout</a></button>
                </div>

            </div>
        </div> -->

        <div class="container my-3">
            <?php 
                if(isset($_GET['insert_category'])){
                    include('insert_category.php');
                }
                if(isset($_GET['insert_products'])){
                    include('insert_products.php');
                }
                if(isset($_GET['view_products'])){
                    include('view_products.php');
                }
                if(isset($_GET['edit_products'])){
                    include('edit_products.php');
                }
                if(isset($_GET['delete_product'])){
                    include('delete_product.php');
                }
                if(isset($_GET['view_categories'])){
                    include('view_categories.php');
                }
                if(isset($_GET['edit_categories'])){
                    include('edit_categories.php');
                }
                if(isset($_GET['delete_categories'])){
                    include('delete_categories.php');
                }
                if(isset($_GET['list_orders'])){
                    include('list_orders.php');
                }
                if(isset($_GET['delete_orders'])){
                    include('delete_orders.php');
                }
                if(isset($_GET['list_payments'])){
                    include('list_payments.php');
                }
                if(isset($_GET['delete_payment'])){
                    include('delete_payment.php'); 
                }
                if(isset($_GET['list_users'])){
                    include('list_users.php');
                }
            ?>
        </div><br><br><br> <br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <!-- include footer -->

                        <?php
                        include("../includes/footer.php")

                        ?>
    </div>
    <!-- bootstrap js -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>