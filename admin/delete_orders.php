<?php

    if(isset($_GET['delete_orders'])){
        $delete_orders = $_GET['delete_orders'];

        $delete_query = "Delete from `user_orders` where order_id='$delete_orders'";
        $result_cat = mysqli_query($con , $delete_query);
        if($result_cat){
            echo "<script>alert('Order Deleted Successfully')</script>";
            echo "<script>window.open('./index.php?list_orders','_self')</script>";
        }
    }


?>