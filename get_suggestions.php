<?php
// Include the necessary files and establish the database connection
include('includes/connect.php');
include('functions/common_functions.php');

// Check if the search query is set
if (isset($_GET['search_query'])) {
    $searchQuery = mysqli_real_escape_string($con, $_GET['search_query']);

    // Get product name suggestions based on the search query
    $suggestions = getProductSuggestions($searchQuery);

    // Display the suggestions
    if (!empty($suggestions)) {
        echo '<ul>';
        foreach ($suggestions as $suggestion) {
            echo '<li>' . htmlspecialchars($suggestion) . '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No suggestions found.';
    }
}

?>
