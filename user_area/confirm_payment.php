<!-- COnnect -->
<?php
include('../includes/connect.php');
session_start();
if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];
    //echo $order_id;
    $select_data = "Select * from `user_orders` where order_id='$order_id'";
    $result = mysqli_query($con , $select_data);
    $row_fetch = mysqli_fetch_assoc($result);
    $invoice_no = $row_fetch['invoice_no'];
    $amount_due = $row_fetch['amount_due'];
}
//else {
    // Handle the case when order_id is not provided, for example, redirect to an error page or display an error message.
    // For now, I'm setting some default values for the variables to avoid errors in the HTML code.
   // $invoice_no = "";
   // $amount_due = "";
//}
if(isset($_POST['confirm_payment'])){
   // $order_id = $_POST['order_id'];
    $invoice_no = $_POST['invoice_no'];
    $amount = $_POST['amount'];
    $payment_mode = $_POST['payment_mode'];
    $insert_query = "insert into `user_payments` (order_id,invoice_no,amount,payment_mode) 
    values('$order_id','$invoice_no','$amount','$payment_mode')";
    $result = mysqli_query($con , $insert_query);
    if($result){
        echo "<h3 class='text-center text-light'>Payment Successfull</h3>";
        echo "<script>window.open('profile.php?my_orders','_self')</script>";
    }
    $update_orders = "Update `user_orders` set order_status='Complete' where order_id='$order_id'";
    $result = mysqli_query($con , $update_orders);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <!-- Bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- link css-->
    <link rel="stylesheet" href="../style.css"
</head>
<body class="bg-secondary">
    <h1 class="text-center text-light">Confirm Payment</h1>
    <div class="container my-5">
        <form action="" method="post">
            <div class="form-outline my-5 text-center w-50 m-auto">
                <input type="text" class="form-control w-50 m-auto" name="invoice_no" value="<?php echo $invoice_no ?>">
            </div>
            <div class="form-outline my-5 text-center w-50 m-auto">
                <label for="" class="text-light">Amount</label>
                <input type="text" class="form-control w-50 m-auto" name="amount_due" value="<?php echo $amount_due ?>">
            </div>
            <div class="form-outline my-5 text-center w-50 m-auto">
                <select name="payment_mode" id="" class="form-select w-50 m-auto">
                    <option>Select Payment Mode</option>
                    <option>Paypal</option>
                    <option>UPI</option>
                    <option>Cash On Delivery</option>
                </select>
            </div>
            <div class="form-outline my-5 text-center w-50 m-auto">
                <input type="submit" class="bg-info py-2 px-3 border-0" value="Confirm" name="confirm_payment">
            </div>
        </form>
    </div>
    
    
</body>
</html>
