<?php
    // Assuming you have already established a database connection
    include('../includes/connect.php');
    include('common_functions.php');
    // Retrieve the submitted product_id from the AJAX request
    $product_id = $_POST['product_id'];

    // Fetch the reviews for the product
    $select_reviews_query = "SELECT * FROM review WHERE product_id = '$product_id'";
    $reviews_result = mysqli_query($con, $select_reviews_query);

    // Calculate the average rating for the product
    $select_avg_rating_query = "SELECT AVG(rating) AS avg_rating FROM review WHERE product_id = '$product_id'";
    $avg_rating_result = mysqli_query($con, $select_avg_rating_query);
    $avg_rating_row = mysqli_fetch_assoc($avg_rating_result);
    $avg_rating = $avg_rating_row['avg_rating'];

    // Prepare the HTML output for reviews and rating
    $output = "<ul class='reviews'>";
    while ($row = mysqli_fetch_assoc($reviews_result)) {
        $username = $row['username'];
        $reviewText = $row['review_text'];
        $submission_date = $row['datetime'];

        $output .= "<li>
            <div class='review-heading'>
                <h5 class='name'>$username</h5>
                <p class='date'>$submission_date</p>
            </div>
            <div class='review-body'>
                <p>$reviewText</p>
            </div>
        </li>";
    }
    $output .= "</ul>";
    $output .= "<p>Average Rating: $avg_rating</p>";

    echo $output;
?>
