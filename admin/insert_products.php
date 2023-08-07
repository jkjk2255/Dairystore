<?php
    include('../includes/connect.php');
    if (isset($_POST['insert_product'])) {
        $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
        $descp = mysqli_real_escape_string($con, $_POST['product_descp']);
        $keyword = mysqli_real_escape_string($con, $_POST['product_keywords']);
        $cat_id = mysqli_real_escape_string($con, $_POST['cat_id']);
        $product_price = mysqli_real_escape_string($con, $_POST['product_price']);
        $product_status = 'true';

        // Images 
        $product_img1 = $_FILES['product_image1']['name'];
        $product_img2 = $_FILES['product_image2']['name'];
        $product_img3 = $_FILES['product_image3']['name'];

        // Image temp names
        $temp_img1 = $_FILES['product_image1']['tmp_name'];
        $temp_img2 = $_FILES['product_image2']['tmp_name'];
        $temp_img3 = $_FILES['product_image3']['tmp_name'];

        // Check for empty fields
        if (empty($product_title) || empty($descp) || empty($keyword) || empty($cat_id) || empty($product_price) ||
            empty($product_img1) || empty($product_img2) || empty($product_img3)) {
            echo "<script>alert('Please fill in all the required fields.')</script>";
        } else {
            // Move uploaded files to destination directory
            move_uploaded_file($temp_img1, "./product_images/$product_img1");
            move_uploaded_file($temp_img2, "./product_images/$product_img2");
            move_uploaded_file($temp_img3, "./product_images/$product_img3");

            // Insert query using prepared statement
            $insert_products = mysqli_prepare($con, "INSERT INTO products (product_title, product_descp, keywords, cat_id, product_img1, product_img2, product_img3, product_price, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
            mysqli_stmt_bind_param($insert_products, "sssssssss", $product_title, $descp, $keyword, $cat_id, $product_img1, $product_img2, $product_img3, $product_price, $product_status);
            
            // Execute the insert statement
            $result = mysqli_stmt_execute($insert_products);

            if ($result) {
                echo "<script>alert('Successfully Inserted.')</script>";
            } else {
                echo "<script>alert('Error inserting data: " . mysqli_error($con) . "')</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products - Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Products</h1>
        <!-- Form -->
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Title -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter Product Title" autocomplete="off" required="required">
            </div>
            <!-- Description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_descp" class="form-label">Product Description</label>
                <input type="text" name="product_descp" id="product_descp" class="form-control" placeholder="Enter Product Description" autocomplete="off" required="required">
            </div>
            <!-- Keywords -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_keywords" class="form-label">Keywords</label>
                <input type="text" name="product_keywords" id="product_keywords" class="form-control" placeholder="Enter keywords" autocomplete="off" required="required">
            </div>
            
           <!-- Categories -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="cat_id" class="form-label">Category</label>
                <select name="cat_id" id="cat_id" class="form-select">
                    <option value="">Select a Category</option>
                    <?php
                        $select_query = "SELECT * FROM categories";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $category_title = $row['cat_name'];
                            $category_id = $row['cat_id'];
                            echo "<option value='$category_id'>$category_title</option>";
                        }
                    ?>
                </select>
            </div>


            <!-- Video URL -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_video_url" class="form-label">Video URL</label>
                <input type="text" name="product_video_url" id="product_video_url" class="form-control" placeholder="Enter Video URL" autocomplete="off">
            </div>


            <!-- Image 1 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class="form-label">Product Image 1</label>
                <input type="file" name="product_image1" id="product_image1" class="form-control" required="required">
             </div>
            <!-- Image 2 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class="form-label">Product Image 2</label>
                <input type="file" name="product_image2" id="product_image2" class="form-control" required="required">
            </div>
            <!-- Image 3 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image3" class="form-label">Product Image 3</label>
                <input type="file" name="product_image3" id="product_image3" class="form-control" required="required">
            </div>
            <!-- Price -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Price</label>
                <input type="text" name="product_price" id="product_price" class="form-control" placeholder="Enter Product Price" autocomplete="off" required="required">
            </div>
            <!-- Submit Button -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3" value="Insert Product">
            </div>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
