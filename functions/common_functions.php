<html>
    <head>
        <!-- Add the jQuery and JavaScript code here -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.product-rating i').click(function() {
      var $star = $(this);
      var $rating = $star.parent(); // Get the rating container of the clicked star
      var $stars = $rating.find('i'); // Get all the stars within the rating container
      var index = $stars.index($star); // Get the index of the clicked star

      // Remove active class from all stars within the same rating container
      $stars.removeClass('active');

      // Add active class to clicked star and previous stars within the same rating container
      $stars.slice(0, index + 1).addClass('active');

      // Update the rating value
      var rating = index + 1;
      console.log('Selected rating: ' + rating);

      // Send the rating value to the server for updating the database
      var productID = $(this).closest('.card-body').find('input[name="product_id"]').val();
      var data = {
        product_id: productID,
        rating: rating
      };

      $.ajax({
        type: 'POST',
        url: 'update_rating.php',
        data: data,
        dataType: 'text', // Specify the data type as text
        success: function(response) {
          console.log(response); // Log the response from the server
        },
        error: function(xhr, status, error) {
          console.error(error); // Log any errors that occur during the AJAX request
        }
      });
    });

    // Retrieve and apply the stored rating on page load for each product
    $('.product-rating').each(function() {
      var $rating = $(this);
      var $stars = $rating.find('i');
      var productID = $rating.closest('.card-body').find('input[name="product_id"]').val();

      // Retrieve the rating value from the server
      $.ajax({
        type: 'POST',
        url: 'get_rating.php',
        data: { product_id: productID },
        dataType: 'json',
        success: function(response) {
          if (response.rating) {
            var rating = parseInt(response.rating);
            $stars.removeClass('active');
            $stars.slice(0, rating).addClass('active');
          } else {
            $stars.removeClass('active'); // Reset the rating if no stored rating found
          }
        },
        error: function(xhr, status, error) {
          console.error(error); // Log any errors that occur during the AJAX request
        }
      });
    });
  });
</script>

<style>
  .product-rating i {
    cursor: pointer;
    color: gray; /* Default color for inactive stars */
  }

  .product-rating i.active {
    color: gold !important; /* Color for active stars */
  }
</style>

    </head>


<body>
    


<?php
  //include('./includes/connect.php');

  // Getting products
  if (!function_exists('getproducts')) {
  function getproducts()
  {
    global $con;

    // Get the selected sorting option from the URL query parameter
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

    // Construct the base SQL query
    $select_query = "SELECT *
    FROM products
    ";

    // Apply sorting if specified
    if ($sort == 'price-low-high') {
      $select_query .= " ORDER BY product_price ASC";
    } elseif ($sort == 'price-high-low') {
      $select_query .= " ORDER BY product_price DESC";
    } elseif ($sort == 'name-a-z') {
      $select_query .= " ORDER BY product_title ASC";
    } elseif ($sort == 'name-z-a') {
      $select_query .= " ORDER BY product_title DESC";
    } else {
      $select_query .= " ORDER BY RAND()";
    }

    // Add limit to the query
    $select_query .= " LIMIT 0, 9";

    $result_query = mysqli_query($con, $select_query);
    if (!$result_query) {
      die(mysqli_error($con));
    }

    while ($row = mysqli_fetch_assoc($result_query)) {
      $product_id = $row['product_id'];
      $product_title = $row['product_title'];
      $product_descp = $row['product_descp'];
      $keywords = $row['keywords'];
      $product_img1 = $row['product_img1'];
      $product_price = $row['product_price'];
      $product_category = $row['cat_id'];
      $rating = $row['rating'];

      echo "<div class='col-md-3 mb-4'>
              <div class='card'>
                <img src='./admin/product_images/$product_img1' class='card-img-top zoom' alt='$product_title'>
                <div class='card-body'>
                  <h5 class='card-title'>$product_title</h5>
                  <p class='card-text' style='font-size: 18px; font-weight: bold;'>₹ $product_price</p>
                  
                  

                  <input type='hidden' name='product_id' value='$product_id'>

                  <div>
                    <a href='product_details.php?product_id=$product_id' class='btn btn-info'>View More</a>
                    <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add To Cart</a>
                  </div>
                </div>
              </div>
            </div>";
    }
  }
}
?>
</body>
</html>





<!--Get unique categories -->
<?php
if (!function_exists('getuniquecategory')) {
function getuniquecategory()
{
    global $con;

    // Check if category is set in the URL parameters
    if (isset($_GET['category'])) {
        $cat_id = $_GET['category'];
        $select_query = "SELECT * FROM `products` WHERE cat_id = $cat_id";
        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);

        if ($num_of_rows == 0) {
            echo "<h2 class='text-center text-danger'>Stock Temporarily Unavailable</h2>";
        } else {
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_descp = $row['product_descp'];
                $keywords = $row['keywords'];
                $product_img1 = $row['product_img1'];
                $product_price = $row['product_price'];
                $product_category = $row['cat_id'];
                $rating = $row['rating'];

                echo "<div class='col-md-4 mb-2'>
                          <div class='card'>
                                <img src='./admin/product_images/$product_img1' class='card-img-top' alt='$product_title'>
                                <div class='card-body'>
                                  <h5 class='card-title'>$product_title</h5>
                                  <p class='card-text' style='font-size: 18px; font-weight: bold;'>₹ $product_price</p>

                                  
                                <input type='hidden' name='product_id' value='$product_id'>

                                  <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add To Cart</a>
                                  <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View More</a>
                                </div>
                          </div>
                      </div>";
            }
            // Exit the function to prevent displaying all products
            return;
        }
    }
    
    // If no category is selected or the category does not exist, display all products
    
}
}



// Getting categories
if (!function_exists('getcategories')) {
function getcategories()
{
    global $con;
    $select_categories = "Select * from `categories`";
    $result_categories = mysqli_query($con, $select_categories);
    while ($row_data = mysqli_fetch_assoc($result_categories)) {
        $cat_title = $row_data['cat_name'];
        $cat_id = $row_data['cat_id'];
        echo "<li class='nav-item'>
          <a href='index.php?category=$cat_id' class='nav-link text-light'>$cat_title</a>
      </li>";
    }
}
}

//getting all products
if (!function_exists('get_all_products')) {
function get_all_products() {
    global $con;
  // Get the selected sorting option from the URL query parameter
  $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

  // Construct the base SQL query
  $select_query = "SELECT p.*
                   FROM products p
                   LEFT JOIN ratings r ON p.product_id = r.product_id
                   GROUP BY p.product_id";
    // Apply sorting if specified
    if ($sort == 'price-low-high') {
        $select_query .= " ORDER BY p.product_price ASC";
    } elseif ($sort == 'price-high-low') {
        $select_query .= " ORDER BY p.product_price DESC";
    } elseif ($sort == 'name-a-z') {
        $select_query .= " ORDER BY p.product_title ASC";
    } elseif ($sort == 'name-z-a') {
        $select_query .= " ORDER BY p.product_title DESC";
    } else {
        $select_query .= " ORDER BY RAND()";
    }

    // Add limit to the query
    $select_query .= " LIMIT 0, 9";

    $result_query = mysqli_query($con, $select_query);
    if (!$result_query) {
        die(mysqli_error($con));
    }

      while($row = mysqli_fetch_assoc($result_query)){
          $product_id = $row['product_id'];
          $product_title = $row['product_title'];
          $product_descp = $row['product_descp'];
          $keywords = $row['keywords'];
          $product_img1 = $row['product_img1'];
          $product_price = $row['product_price'];
          $product_category = $row['cat_id'];
          $rating = $row['rating'];
          echo "<div class='col-md-3 mb-4'>
          <div class='text-center'>
              <div class='card'>
                  <img src='./admin/product_images/$product_img1' class='card-img-top' alt='$product_title'>
                  <div class='card-body'>
                      <h5 class='card-title'>$product_title</h5>
                      <p class='card-text' style='font-size: 18px; font-weight: bold;'>₹ $product_price</p>

                      

                  <input type='hidden' name='product_id' value='$product_id'>
                      
                      <div>
                          <a href='product_details.php?product_id=$product_id' class='btn btn-info'>View More</a>
                          <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add To Cart</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>";
}
  }
}




//get search products
if (!function_exists('search_product')) {
function search_product(){
    global $con;

    // Get the selected sorting option from the URL query parameter
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

    if(isset($_GET['search_data_product'])){
        $search_data_value = $_GET['search_data'];
        $select_query = "SELECT * FROM `products` WHERE product_title LIKE '%$search_data_value%' ";

        // Apply sorting if specified
        if ($sort == 'price-low-high') {
            $select_query .= " ORDER BY product_price ASC";
        } elseif ($sort == 'price-high-low') {
            $select_query .= " ORDER BY product_price DESC";
        } elseif ($sort == 'name-a-z') {
            $select_query .= " ORDER BY product_title ASC";
        } elseif ($sort == 'name-z-a') {
            $select_query .= " ORDER BY product_title DESC";
        } else {
            $select_query .= " ORDER BY RAND()";
        }

        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);

        if ($num_of_rows == 0) {
            echo "<h2 class='text-center text-danger'>No Results Found!</h2>";
        }

        while($row = mysqli_fetch_assoc($result_query)){
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_descp = $row['product_descp'];
            $keywords = $row['keywords'];
            $product_img1 = $row['product_img1'];
            $product_price = $row['product_price'];
            $product_category = $row['cat_id'];
            $rating = $row['rating'];
            echo "<div class='col-md-4 mb-2'>
                <div class='text-center'>
                    <div class='card'>
                        <img src='./admin/product_images/$product_img1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text' style='font-size: 18px; font-weight: bold;'>₹ $product_price</p>

                            
        
                          <input type='hidden' name='product_id' value='$product_id'>
                            
                            <div>
                                <a href='product_details.php?product_id=$product_id' class='btn btn-info'>View More</a>
                                <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
        }

        if ($num_of_rows == 0) {
            // Fetch and display all products
            $all_products_query = "SELECT * FROM `products`";
            $all_products_result = mysqli_query($con, $all_products_query);

            while ($row = mysqli_fetch_assoc($all_products_result)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_descp = $row['product_descp'];
                $keywords = $row['keywords'];
                $product_img1 = $row['product_img1'];
                $product_price = $row['product_price'];
                $product_category = $row['cat_id'];

                echo "<div class='col-md-4 mb-2'>
                    <div class='text-center'>
                        <div class='card'>
                            <img src='./admin/product_images/$product_img1' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text' style='font-size: 18px; font-weight: bold;'>₹ $product_price</p>

                                <input type='hidden' name='product_id' value='$product_id'>
                                
                                <div>
                                    <a href='product_details.php?product_id=$product_id' class='btn btn-info'>View More</a>
                                    <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
        }
    }
}
}
?>

<html>
    <head>
    <head>
  <!-- Other head elements -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    .rating {
        color: gold;
    }

    .rating .star {
        font-size: 20px;
    }

    .rating .star.checked {
        color: orange;
    }
</style>
</head>

    
    <body>
            
     <?php
// View details
if (!function_exists('view_details')) {
    function view_details() {
        global $con;

        // Check if product_id is set
        if (isset($_GET['product_id'])) {
            if (!isset($_GET['category'])) {
                $product_id = $_GET['product_id'];

                $select_query = "SELECT p.*
                                 FROM products p
                                 WHERE p.product_id = $product_id";

                $result_query = mysqli_query($con, $select_query);

                while ($row = mysqli_fetch_assoc($result_query)) {
                    $product_id = $row['product_id'];
                    $product_title = $row['product_title'];
                    $product_descp = $row['product_descp'];
                    $keywords = $row['keywords'];
                    $product_img1 = $row['product_img1'];
                    $product_img2 = $row['product_img2'];
                    $product_img3 = $row['product_img3'];
                    $product_price = $row['product_price'];

                    $product_category = $row['cat_id'];
                    $product_video_url = $row['video_url']; // Assuming the video URL is stored in the 'video_url' column

                    echo "<div class='col-md-10 mb-2 mx-auto'>
                            <div class='row'>
                                <div class='col-6'>
                                    <div class='image-preview-wrapper' style='display: flex; margin: 0; padding: 0;'>
                                        <div class='image-previews'>
                                            <img src='./admin/product_images/$product_img1' class='preview-image' alt='$product_title' onclick='changeImage(this)'>
                                            <img src='./admin/product_images/$product_img2' class='preview-image' alt='$product_title' onclick='changeImage(this)'>
                                            <img src='./admin/product_images/$product_img3' class='preview-image' alt='$product_title' onclick='changeImage(this)'>
                                        </div>
                                        
                                        <div class='large-preview'>
                                            <img id='productImg' src='./admin/product_images/$product_img1' class='large-image' alt='$product_title'>
                                            
                                            <input type='hidden' name='product_id' value='$product_id'>
                                            <div class='action-buttons'>
                                                <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add To Cart</a>
                                                <a href='#' class='btn btn-primary'>Buy Now</a>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                
                                <div class='col-6'>
                                    <div class='product-details'>
                                        <h5 class='card-title'>$product_title</h5>
                                        <p class='card-text' style='font-size: 18px; font-weight: bold;'>₹ $product_price</p>
                                        <p class='card-text'>$product_descp</p>
                                    </div>
                                </div>
                            </div>
                            
                           <div class='row'>
                                <div class='col-12'>
                                    <div id='review_field'>
                                        <h3 class='mt-4 mb-3'>Write Review Here</h3>
                                        <div class='form-group'>
                                            <input type='text' name='username' id='username' class='form-control' placeholder='Enter Your Name' />
                                        </div>
                                        <div class='form-group'>
                                            <textarea name='review_text' id='review_text' class='form-control' placeholder='Type Review Here'></textarea>
                                        </div>
                                         <div class='form-group text-center mt-4'>
                                            <button type='button' class='btn btn-primary' id='submit_review'>Submit</button>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <h4 class='text-center mt-2 mb-4'>
                                                <i class='fas fa-star star-light submit_star mr-1' id='submit_star_1' data-rating='1'></i>
                                                <i class='fas fa-star star-light submit_star mr-1' id='submit_star_2' data-rating='2'></i>
                                                <i class='fas fa-star star-light submit_star mr-1' id='submit_star_3' data-rating='3'></i>
                                                <i class='fas fa-star star-light submit_star mr-1' id='submit_star_4' data-rating='4'></i>
                                                <i class='fas fa-star star-light submit_star mr-1' id='submit_star_5' data-rating='5'></i>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>";

                    // Fetch and display reviews
                    $select_reviews_query = "SELECT * FROM reviews WHERE product_id = '$product_id'";
                    $reviews_result = mysqli_query($con, $select_reviews_query);

                    echo "<div class='container'>
                            <h1 class='mt-5 mb-5'></h1>
                            <div class='card'>
                                <div class='card-header'>Customer Reviews</div>
                                <div class='card-body'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <div id='reviews'>
                                                <ul class='reviews'>";

                                                while ($row = mysqli_fetch_assoc($reviews_result)) {
                                                    $username = $row['username'];
                                                    $reviewText = $row['review_text'];
                                                    $submission_date = $row['submission_date'];
                                                    $rating = $row['rating'];
                                                
                                                    echo "<li>
                                                        <div class='review-heading'>
                                                            <h5 class='name'>$username</h5>
                                                            <p class='date'>$submission_date</p>
                                                        </div>
                                                        <div class='review-body'>
                                                            <p>$reviewText</p>
                                                        </div>
                                                        <div class='rating'>
                                                            ";
                                                
                                                    // Display the rating as stars
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i <= $rating) {
                                                            echo "<span class='star checked'>&#9733;</span>";
                                                        } else {
                                                            echo "<span class='star'>&#9733;</span>";
                                                        }
                                                    }
                                                
                                                    echo "
                                                        </div>
                                                    </li>";
                                                }
                                                
                     
                    echo "              </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='mt-5' id='review_content'></div>
                        </div>
                        
                        <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>

                        <script>


                        // Fetch and display reviews and average rating
function fetchReviews() {
  $.ajax({
    type: 'POST',
    url: 'functions/fetch_review.php',
    data: {
      product_id: $product_id
    },
    success: function(response) {
      $('#reviews').html(response);
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText);
    }
  });
}

$(document).ready(function() {
  // Submit review functionality
  $('#submit_review').click(function() {
    var username = $('#username').val();
    var reviewText = $('#review_text').val();
    var rating = $('.submit_star.checked').length;

    // Perform validation here if needed

    $.ajax({
      type: 'POST',
      url: 'functions/submit_review.php',
      data: {
        product_id: $product_id,
        username: username,
        review_text: reviewText,
        rating: rating
      },
      success: function(response) {
        console.log(response);
        if (response === 'true') {
          alert('Review submitted successfully');
          // Clear input fields
          $('#username').val('');
          $('#review_text').val('');
          $('.submit_star').removeClass('checked');
        } else if (response === 'false') {
          // User not logged in
          console.log('User not logged in');
          alert('You need to be logged in to submit a review.');
          // Redirect the user to the login page
          window.location.href = 'user_area/user_login.php';
        } else {
          // Handle other response cases if needed
        }
        
        fetchReviews(); // Refresh the review list
      },
      error: function(xhr, status, error) {
        console.log('AJAX request error:', error);
      }
    });
  });

  // Initial fetch of reviews and average rating
  fetchReviews();

  // Star rating functionality
  $('.submit_star').hover(
    function() {
      $(this).prevAll().addClass('hover');
      $(this).addClass('hover');
    },
    function() {
      $(this).prevAll().removeClass('hover');
      $(this).removeClass('hover');
    }
  );

  $('.submit_star').click(function() {
    $(this).prevAll().addClass('checked');
    $(this).addClass('checked');
    $(this).nextAll().removeClass('checked');
  });
});

                          
                          
                            
                          
</script>";
                }
echo "<script src='https://unpkg.com/zooming/build/zooming.min.js'></script>";
echo "<script>
    function changeImage(element) {
        var img = document.getElementById('productImg');
        img.src = element.src;
    }

    new Zooming({
        customSize: { width: 300, height: 300 },
    }).listen('.large-image');
</script>"; 

echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";

echo "<style>

.progress-label-left
{
    float: left;
    margin-right: 0.5em;
    line-height: 1em;
}
.progress-label-right
{
    float: right;
    margin-left: 0.3em;
    line-height: 1em;
}
.star-light
{
	color:#e9ecef;
}
.submit_star:hover {
    color: yellow;
  }
  .star-hover,
.checked {
  color: yellow;
}

  


    .image-previews {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 10px; /* Add margin bottom to create space */
        margin-right: 45px;
    }

    .image-previews .preview-image {
        width: 50px;
        height: 50px;
        margin-bottom: 5px;
        cursor: pointer;
    }

    .large-preview {
        display: inline-block;
        text-align: center;
        margin-bottom: 20px; /* Add margin bottom for spacing */
        margin-left: 50px; /* Add margin left to create space */
    }
    
    .large-preview .large-image {
        width: 300px;
        height: 300px;
        transition: transform 0.3s;
    }

    .large-preview:hover .large-image {
        transform: scale(1.1);
        cursor: zoom-in;
    }

    .embed-responsive .embed-responsive-item {
        width: 50px;
        height: 50px;
        margin-top: 10px;
    }

    .action-buttons {
        margin-top: 10px;
        text-align: center;
    }

    .product-rating {
        margin-top: 12px; /* Adjust the margin-top value as desired */
    }

    .product-details {
        margin-top: 20px;
    }

    .product-details h5,
    .product-details p {
        margin: 0;
    }
</style>";
           }
        }
    }
}
?>    </body>
</html>





<?php
// get ip address
if (!function_exists('getIPAddress')) {
function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  
}
// $ip = getIPAddress();  
// echo 'User Real IP Address - '.$ip;  


//cart function

if (!function_exists('cart')) {
function cart(){
    if(isset($_GET['add_to_cart'])){
        global $con;
        $get_ip_address = getIPAddress();
        $get_product_id = $_GET['add_to_cart'];
        $select_query = "Select * from `cart_details` where ip_address='$get_ip_address' and product_id=$get_product_id";
        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if ($num_of_rows > 0) {
          echo "<script>alert('Item Is Already Present Inside Cart')</script>";
          echo "<script>window.open('cart.php','_self')</script>";
         } else{
            $insert_query = "insert into `cart_details` (product_id,ip_address,quantity) values($get_product_id,'$get_ip_address',0)";
            $result_query = mysqli_query($con, $insert_query);
            echo "<script>alert('Item Successfully Added To Cart')</script>";
            echo "<script>window.open('cart.php','_self')</script>";
 }
    }
}
}

//cart item number
if (!function_exists('cart_item')) {
function cart_item(){
    if(isset($_GET['add_to_cart'])){
        global $con;
        $get_ip_address = getIPAddress();
        $select_query = "Select * from `cart_details` where ip_address='$get_ip_address'";
        $result_query = mysqli_query($con, $select_query);
        $count_cart_items=mysqli_num_rows($result_query);
        }else {
            global $con;
        $get_ip_address = getIPAddress();
        $select_query = "Select * from `cart_details` where ip_address='$get_ip_address'";
        $result_query = mysqli_query($con, $select_query);
        $count_cart_items=mysqli_num_rows($result_query);
        }
        echo $count_cart_items;
    }
}

    //total price
    if (!function_exists('total_cart_price')) {
    function total_cart_price(){
        global $con;
        $get_ip_address = getIPAddress();
        $total=0;
        $cart_query = "Select * from `cart_details` where ip_address='$get_ip_address'";
        $result_query = mysqli_query($con,$cart_query);

        while($row = mysqli_fetch_array($result_query)){
            $product_id = $row['product_id'];
            $select_products = "Select * from `products` where product_id='$product_id'";
            $result_products = mysqli_query($con,$select_products);
            while($row_product_price = mysqli_fetch_array($result_products)){
                $product_price = array($row_product_price['product_price']);
                $product_values = array_sum($product_price);
                $total+=$product_values;
            }
        }
        echo $total;             
    }
}



    //get user order details
    if (!function_exists('get_user_order_details')) {
    function get_user_order_details(){
        global $con;
        $username = $_SESSION['username'];
        $get_details = "Select * from `user_table` where 
        username='$username'";
        $result_query = mysqli_query($con , $get_details);
        while($row_query=mysqli_fetch_array($result_query)){
            $user_id = $row_query['user_id'];
            if(!isset($_GET['edit_account'])){
                if(!isset($_GET['my_orders'])){
                    if(!isset($_GET['delete_account'])){
                        $get_orders = "Select * from `user_orders` where
                        user_id=$user_id and order_status='pending'";
                        $result_orders_query = mysqli_query($con , $get_orders);
                        $row_count = mysqli_num_rows($result_orders_query);
                        if($row_count>0){
                            echo "<h3 class='text-center text-success my-5'>You have <span class=
                            'text-danger'>$row_count </span> Pending Orders</h3>
                            <p class='text-center'><a href='profile.php?my_orders' class='text-dark'>
                            Order Details</a></p>";
                        } else{
                            echo "<h3 class='text-center text-success my-5'>You have 0 Pending Orders</h3>
                            <p class='text-center'><a href='../index.php' class='text-dark'>
                            Explore Products</a></p>";
                        }
            }
        }
    }
    }
}
}
?>