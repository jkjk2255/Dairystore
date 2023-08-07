<!-- COnnect -->
<?php
include('includes/connect.php');
include('functions/common_functions.php');
session_start();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dairy Farm</title>
    <!-- Bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link css-->
    <link rel="stylesheet" href="style.css">
     
</head>
<body>


    <!-- navbar-->


    <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-info">
        <div class="container-fluid">
            <img src="./images/logo3.png" alt="" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="display_all.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Total Price: <?php total_cart_price();?>/-</a>
                    </li>
                </ul>

                <!-- Sorting dropdown menu -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSort" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sort
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownSort">
                            <li><a class="dropdown-item" href="?sort=price-low-high">Price (Low to High)</a></li>
                            <li><a class="dropdown-item" href="?sort=price-high-low">Price (High to Low)</a></li>
                            <li><a class="dropdown-item" href="?sort=name-a-z">Name (A to Z)</a></li>
                            <li><a class="dropdown-item" href="?sort=name-z-a">Name (Z to A)</a></li>
                        </ul>
                    </li>
                </ul>

                <form class="d-flex mx-auto" role="search" action="search_product.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <sup><?php cart_item();?></sup>
                        </a>
                    </li>
                    
                    
                    <li class="nav-item">
                        <a class="nav-link" href="./user_area/user_registration.php">Register</a>
                    </li>
                    <?php
          if(!isset($_SESSION['username'])){
            echo "<li class='nav-item'>
            <a class='nav-link' href='./user_area/user_login.php'>Login</a>
          </li>";
          }else {
            echo "<li class='nav-item'>
            <a class='nav-link' href='./user_area/logout.php'>Logout</a>
          </li>";
          }
      ?>
                </ul>
            </div>
        </div>
    </nav>
</div>


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

    <!-- Center-aligned elements -->
    <ul class="navbar-nav mx-auto">
      <!-- get categories -->
      <?php
        getcategories();
      ?>
    </ul>
  </div>
</nav>

<div class="bg light" style ="text-align:center;">
    <h3 class="center">Dairy Shop</h3>
    <p class="textcenter">All You Need Is Here</p>
  </div>

  

      <div class="row px-1">
        <div class="col-md-12">
          <!-- products -->
          <div class="row">
            <!-- fetch products -->
            <?php
                get_all_products();
              //  getuniquecategory();
            ?> 
        <!-- row end -->
          </div>
        <!-- col end -->
          </div>
      </div>

<br>
<br>
<br>
<br>
<!-- include footer -->

<?php
  include("./includes/footer.php")

?>

      </div>


    </div>

   <!-- Rest of your PHP code... -->

<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>



</body>
</html>


