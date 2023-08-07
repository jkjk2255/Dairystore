<?php
    if(isset($_GET['edit_products'])){
        $edit_id = $_GET['edit_products'];
        $get_data = "Select * from `products` where product_id='$edit_id'";
        $result = mysqli_query($con , $get_data);
        $row = mysqli_fetch_assoc($result);
        $product_title = $row['product_title'];
        //echo $product_title;
        $product_descp = $row['product_descp'];
        $keywords = $row['keywords'];
        $cat_id = $row['cat_id'];
        $product_img1 = $row['product_img1'];
        $product_img2 = $row['product_img2'];
        $product_img3 = $row['product_img3'];
        $product_price = $row['product_price'];
        
        //fetching category name
        $select_category = "Select * from `categories` where cat_id='$cat_id'";
        $result_category = mysqli_query($con , $select_category);
        $row_category = mysqli_fetch_assoc($result_category);
        $category_title = $row_category['cat_name'];
    }

?>



<div class="container mt-5">
    <h1 class="text-center">Edit Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" id="product_title" name="product_title" class="form-control"
            value="<?php echo $product_title ?>" >   
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_desc" class="form-label">Product Description</label>
            <input type="text" id="product_desc" name="product_descp" class="form-control"
            value="<?php echo $product_descp ?>" required="required">   
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_keywords" class="form-label">Product Keywords</label>
            <input type="text" id="product_keywords" name="keywords" class="form-control"
            value="<?php echo $keywords ?>" required="required">   
        </div>
        <div class="form-outline w-50 m-auto mb-4">
        <label for="product_cat" class="form-label">Product Category</label>
            <select name="product_cat" id="" class="form-select">
                <option value="<?php echo $category_title?>"><?php echo $category_title?></option>
                <?php
                       $select_category_all = "Select * from `categories`";
                       $result_category_all = mysqli_query($con , $select_category_all);
                       while($row_category_all = mysqli_fetch_assoc($result_category_all)){
                            $category_title = $row_category_all['cat_name'];
                            $cat_id = $row_category_all['cat_id'];
                            echo "<option value='$category_id'>$category_title</option>";
                       };           
                ?>
            </select>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_img1" class="form-label">Product Image1</label>
            <div class="d-flex">
                <input type="file" id="product_img1" name="product_img1" class="form-control w-90 m-auto""
                required="required"> 
                <img src="../images/<?php echo $product_img1;?>" alt="" width='90px' height='90px' m-'auto'>
            </div>     
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_img2" class="form-label">Product Image2</label>
            <div class="d-flex">
                <input type="file" id="product_img2" name="product_img2" class="form-control w-90 m-auto""
                required="required"> 
                <img src="../images/<?php echo $product_img2;?>" alt="" width='90px' height='90px' m-'auto'>
            </div>     
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_img3" class="form-label">Product Image3</label>
            <div class="d-flex">
                <input type="file" id="product_img3" name="product_img3" class="form-control w-90 m-auto"
                required="required"> 
                <img src="../images/<?php echo $product_img3;?>" alt=""  width='90px' height='90px' m-'auto'>
            </div>     
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="text" id="product_price" name="product_price" class="form-control"
            value="<?php echo $product_price ?>" required="required">   
        </div>
        <div class="text-center">
            <input type="submit" name="edit_product" value="Update Product" class="btn bg-info px-3 mb-3">
        </div>
    </form>
</div>

<!-- editing products -->
<?php
    if(isset($_POST['edit_product'])){
        $product_title = $_POST['product_title'];
        $product_descp = $_POST['product_descp'];
        $product_cat = $_POST['product_cat'];
        $product_price = $_POST['product_price'];

        $product_img1 = $_FILES['product_img1']['name'];
        $product_img2 = $_FILES['product_img2']['name'];
        $product_img3 = $_FILES['product_img3']['name'];

        $temp_img1 = $_FILES['product_img1']['tmp_name'];
        $temp_img2 = $_FILES['product_img2']['tmp_name'];
        $temp_img3 = $_FILES['product_img3']['tmp_name'];

        //checking for empty field

        if($product_title == '' or $product_descp == '' 
        or $product_cat == '' or $product_img1 == '' or $product_img2 == '' 
        or $product_img3 == '' or $product_price == ''){
            echo "<script>alert('Please Fill All The Fields')</script>";
        }else{
            move_uploaded_file($temp_img1,"./product_images/$product_img1");
            move_uploaded_file($temp_img2,"./product_images/$product_img2");
            move_uploaded_file($temp_img3,"./product_images/$product_img3");

            //update product

            $update_product = "Update `products` set product_title='$product_title',
            product_descp='$product_descp', cat_id='$product_cat', product_img1='$product_img1',
            product_img2='$product_img2',product_img3='$product_img3',
            product_price='$product_price',date=NOW() where product_id='$edit_id'";

            $result_update = mysqli_query($con , $update_product);
            if($result_update){
                echo "<script>alert('Product Updated Successfully')</script>";
                echo "<script>window.open('index.php?view_products','_self')</script>";
            }
            
        }
    }
?>


