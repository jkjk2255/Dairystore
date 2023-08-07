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
    <style>
        .cart_img{
    width: 80px;
    height: 80px;
    object-fit:contain;
  }
        </style>
     
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

    <!-- Center-aligned elements -->
    <ul class="navbar-nav mx-auto">
      <!-- get categories -->
      <?php
        getcategories();
      ?>
    </ul>
  </div>
</nav>

<!-- calling cart function -->
<?php
  cart();
?>


 
<div class="bg light" style ="text-align:center;">
    <h3 class="center">Dairy Shop</h3>
    <p class="textcenter">All You Need Is Here</p>
  </div>

  <!-- table -->

  <div class="container">
    <div class="row">
      <form action="" method="post">
        <table class="table table-bordered text-center">
            
            
                <!-- php code to display dynamic data -->
                <?php
                
                    
                    $get_ip_address = getIPAddress();
                    $total=0;
                    $cart_query = "Select * from `cart_details` where ip_address='$get_ip_address'";
                    $result_query = mysqli_query($con,$cart_query);
                    $result_count = mysqli_num_rows($result_query);

                    if($result_count>0){
                      echo "<thead>
                      <tr>
                          <th>Product title</th>
                          <th>Product Image</th>
                          <th>Quantity</th>
                          <th>Total Price</th>
                          <th>Remove</th>
                          <th colspan='2'>Operations</th>
                      </tr>
                  </thead>
                  <tbody>";

                    
            
                    while($row = mysqli_fetch_array($result_query)){
                        $product_id = $row['product_id'];
                        $select_products = "Select * from `products` where product_id='$product_id'";
                        $result_products = mysqli_query($con,$select_products);
                        while($row_product_price = mysqli_fetch_array($result_products)){
                            $product_price = array($row_product_price['product_price']);
                            $price_table = $row_product_price['product_price'];
                            $product_title = $row_product_price['product_title'];
                            $product_img1 = $row_product_price['product_img1'];
                            $product_values = array_sum($product_price);
                            $total+=$product_values;
                                
                ?>
                <tr>
                    <td><?php echo $product_title ?></td>
                    <td><img src="./admin/product_images/<?php echo $product_img1?>" alt="" class="cart_img"></td>
                    <td><input type="text" name="qty" class="form-input w-50"></td>

                    <?php
                        $get_ip_address = getIPAddress();
                        if(isset($_POST['update_cart'])){
                          $quantities=$_POST['qty'];
                          $update_cart="UPDATE `cart_details` SET quantity=$quantities WHERE 
                          ip_address='$get_ip_address'";
                          $result_cart=mysqli_query($con,$update_cart);
                          $total=$total*$quantities;
                       }

                    ?>
                    <td><?php echo $price_table?></td>
                    <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id ?>"></td>
                    <td>
                      <!--  <button class="bg-info px-3 py-2 border-0 mx-3">Update</button> -->
                          <input type="submit" value="Update Cart"
                          class="bg-info px-3 py-2 border-0 mx-3" name="update_cart">
                      <!--  <button class="bg-info px-3 py-2 border-0 mx-3">Remove</button> --> 
                          <input type="submit" value="Remove Item"
                          class="bg-info px-3 py-2 border-0 mx-3" name="remove_cart">
                        
                    </td>
                </tr>
                <?php } } }
                else{
                  echo "<h2 class='text-center text-danger'>Cart Is Empty</h2>";
                }    
               ?>
            </tbody>
        </table>
        <!-- subtotal -->
        <div class="d-flex mb-5">
          <?php
            $get_ip_address = getIPAddress();
            $cart_query = "Select * from `cart_details` where ip_address='$get_ip_address'";
            $result_query = mysqli_query($con,$cart_query);
            $result_count = mysqli_num_rows($result_query);

            if($result_count>0){
              echo " <h4 class='px-4'>Subtotal:<strong class='text-info'>$total /-</strong></h4>
              <input type='submit' value='Continue Shopping'
                          class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>
              <button class='bg-secondary px-3 py-2 border-0 text-light'><a href='./user_area/checkout.php' class='text-light text-decoration-none'>Checkout</a></button>";
            }else{
              echo "<input type='submit' value='Continue Shopping'
              class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>";
            }
            if(isset($_POST['continue_shopping'])){
              echo "<script>window.open('index.php','_self')</script>";
            }
                ?>
            
        </div>
    </div>
  </div>
  </form>

  <!-- function to remove item -->

  <?php
    function remove_cart_item(){
    global $con;
      if(isset($_POST['remove_cart'])){
        foreach($_POST['removeitem'] as $remove_id){
          echo $remove_id;
          $delete_query = "delete from `cart_details` where product_id=$remove_id";
          $run_delete = mysqli_query($con , $delete_query);
          if($run_delete){
            echo "<script>window.open('cart.php','_self')</script>";
          }
        }
      }
    }
    echo $remove_item = remove_cart_item();





?>



<!-- include footer -->

<?php
  include("./includes/footer.php")

?>

   </div>


    </div>

   

<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>



</body>
</html>


