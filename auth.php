<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$dbhost = "localhost";
$dbname = "student_management_system";
$dbuser = "postgres";
$dbpass = "David910139";

try {
  // Create a new PDO instance
  $conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Retrieve the username and password from the login form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare an SQL query to check if the username and password are valid
  $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username AND password=:password");

  // Bind the username and password parameters to the prepared statement
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $password);

  // Execute the prepared statement
  $stmt->execute();

  // $user_id = $conn->query("SELECT id FROM users WHERE username=:username")->fetch();




 
  //Get User_ID
  // $pdo = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

  // $stmt1->execute();
  // $user = $stmt1->fetch(PDO::FETCH_ASSOC);

  // If the query returns a single row, the username and password are valid
  if ($stmt->rowCount() == 1) {
    $user_id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    // Redirect the user to the home page
    $_SESSION['user_id'] = $user_id;
    header("Location: home.php");
    exit;
  } else {
    // Otherwise, redirect the user back to the login page with a login_failed parameter in the query string
    header("Location: login.php?login_failed=1");
    exit;
  }
} catch(PDOException $e) {
  // If an exception is thrown, display an error message
  echo "Connection failed: " . $e->getMessage();
}

// Close the database connection
$conn = null;



?>


