<?php

    if(isset($_GET['delete_categories'])){
        $delete_categories = $_GET['delete_categories'];

        $delete_query = "delete from `categories` where cat_id='$delete_categories'";
        $result_cat = mysqli_query($con , $delete_query);
        if($result_cat){
            echo "<script>alert('Category Deleted Successfully')</script>";
            echo "<script>window.open('./index.php?view_categories','_self')</script>";
        }
    }


?>