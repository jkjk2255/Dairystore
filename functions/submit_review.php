
<?php /*
// save_review.php
include('../includes/connect.php');
include('../functions/common_functions.php');
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted data
    $username = $_POST['username'];
    $reviewText = $_POST['review_text'];
    $rating = $_POST['rating'];
    $productId = $_POST['productId'];

    // Insert the review into the database
    // Assuming you have a database connection established
    $insertQuery = "INSERT INTO review (product_id, username, review_text, rating) VALUES ('$productId', '$username', '$reviewText', '$rating')";
    // Execute the query using your preferred method (e.g., mysqli_query)

    if ($insertQuery) {
        // Return a success response
        $response = array('success' => true);
        echo json_encode($response);
        exit;
    }
}

// Return an error response if the review couldn't be saved
$response = array('success' => false);
echo json_encode($response);
exit;
?> */
?>

<?php
// Assuming you have already established a database connection
include('../includes/connect.php');
include('common_functions.php');

// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
  // User is logged in, process the review submission
  $product_id = $_POST['product_id'];
  $username = $_POST['username'];
  $review_text = $_POST['review_text'];
  $rating = $_POST['rating'];

  // Perform any necessary validation here

  // Prepare the SQL query to insert the review into the database
  $insert_review_query = "INSERT INTO review (product_id, username, review_text, rating) 
                          VALUES ('$product_id', '$username', '$review_text', $rating)";

  // Execute the query
  if (mysqli_query($con, $insert_review_query)) {
    echo "true"; // Review submitted successfully
    echo "<script>alert('Review submitted successfully');</script>";
  } else {
    echo "Error: " . mysqli_error($con);
  }
}  else {
    // User is not logged in
    error_log('User not logged in');
    echo 'false'; // Review submission failed
    echo "<script>alert('User Not Logged In');</script>";
  }
  
?>






