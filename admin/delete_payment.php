<?php

    if(isset($_GET['delete_payment'])){
        $delete_payment = $_GET['delete_payment'];

        $delete_query = "delete from `user_payments` where payment_id='$delete_payment'";
        $result_cat = mysqli_query($con , $delete_query);
        if($result_cat){
            echo "<script>alert('Payment Deleted Successfully')</script>";
            echo "<script>window.open('./index.php?list_payments','_self')</script>";
        }
    }


?>