<?php
if(isset($_GET['edit_categories'])){
    $edit_categories = $_GET['edit_categories'];

    $get_categories = "select * from `categories` where cat_id='$edit_categories'";
    $result = mysqli_query($con , $get_categories);
    $row = mysqli_fetch_assoc($result);
    $cat_name = $row['cat_name'];
    //echo $cat_name;
}
if(isset($_POST['edit_categories'])){
    $cat_name = $_POST['cat_name'];

    $update_query = "update `categories` set cat_name='$cat_name' where cat_id='$edit_categories'";
    $result_cat = mysqli_query($con , $update_query);
    if($result_cat){
        echo "<script>alert('Category Updated Successfully')</script>";
        echo "<script>window.open('./index.php?view_categories','_self')</script>";
    }
}
?>





<div class="container mt-3">
    <h1 class="text-center">Edit Category</h1>
    <form action="" method="post" class="text-center">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="cat_name" class="form-label">Category Title</label>
            <input type="text" id="cat_name" name="cat_name" class="form-control" 
            required="required" value="<?php echo $cat_name; ?>">
        </div>
        <input type="submit" class="btn btn-info px-3 mb-3"
        name="edit_categories">
    </form>
</div>