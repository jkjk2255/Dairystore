<?php 
// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
  // User is logged in
  echo 'true';
} else {
  // User is not logged in
  echo 'false';
}
?> 


