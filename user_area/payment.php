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
    <title>Document</title>
     <!-- Bootstrap  -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

<!-- font awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- link css-->
<link rel="stylesheet" href="style.css">

<style>
    .payment_img{
        width: 50%;
        margin: auto;
        display: block;
    }
</style>

</head>
<body>

    <!-- php code to access user id -->

    <?php
        $user_ip = getIPAddress();
        $get_user = "Select * from `user_table` where user_ip='$user_ip'";
        $result = mysqli_query($con , $get_user);
        $run_query = mysqli_fetch_array($result);
        $user_id = $run_query['user_id'];





    ?>


    <div class="container">
        <h2 class="text-center text-info">
            Payment Options
        </h2>
        <div class="row d-flex justify-content-center align-items-center my-5">
            <div class="col-md-6">
                <a href="https://www.paypal.com" target="_blank"><img src="../images/logo3.png" class="payment_img" alt=""></a>
            </div>
            <div class="col-md-6">
                <a href="orders.php?user_id=<?php echo $user_id ?>"><h2 class="text-center">Pay Offline</h2></a>
            </div>
        </div>
    </div>
</body>
</html> 