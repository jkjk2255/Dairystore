<?php
// Include the database connection and initialization code

// Assuming you have included the necessary code to connect to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the product ID from the request
  $productID = $_POST['product_id'];

  // Perform the database query to retrieve the rating
  // Retrieve the "rating" value from the "products" table for the given product ID

  // Replace the placeholders with your actual table and column names
  $select_query = "SELECT rating FROM products WHERE product_id = $productID";

  $result = mysqli_query($con, $select_query);
  if (!$result) {
    die(mysqli_error($con));
  }

  $row = mysqli_fetch_assoc($result);
  $rating = $row['rating'];

  // Return the rating value as JSON response
  echo json_encode(['rating' => $rating]);
}
?>
