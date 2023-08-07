<?php
// Include the database connection and initialization code

// Assuming you have included the necessary code to connect to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the product ID and rating value from the request
  $productID = $_POST['product_id'];
  $rating = $_POST['rating'];

  // Perform the database update to store the rating
  // Update the "rating" column of the "products" table with the new rating value for the given product ID

  // Replace the placeholders with your actual table and column names
  $update_query = "UPDATE products SET rating = $rating WHERE product_id = $productID";

  $result = mysqli_query($con, $update_query);
  if (!$result) {
    die(mysqli_error($con));
  }

  echo 'Rating updated successfully';
}
?>
