<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbhost = "localhost";
$dbname = "student_management_system";
$dbuser = "postgres";
$dbpass = "David910139";

try {
  // Create a new PDO instance
  $conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Retrieve the courses for the current user
  $user_id = $_SESSION['user_id'];
  $stmt = $conn->prepare("SELECT c.course_id, c.course_name, c.num_students, u.username AS professor_name 
  FROM courses c 
  JOIN users u ON c.id = u.id 
  WHERE c.id = :user_id 
  ORDER BY c.course_id");

  $stmt->bindParam(':user_id', $user_id);
  $stmt->execute();
  $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
  // If an exception is thrown, display an error message
  echo "Connection failed: " . $e->getMessage();
}

// Close the database connection
$conn = null;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Class Dashboard</title>
	<link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
<h1>Class Dashboard</h1>
  <?php foreach ($courses as $course): ?>
    <a href="class_detail.php?course_id=<?php echo $course['course_id']; ?>">
      <div class="class-box" style="text-decoration:none">
        <h2><?php echo $course['course_name']; ?></h2>
        <p>Course ID: <?php echo $course['course_id']; ?></p>
        <p>Number of Students: <?php echo $course['num_students']; ?></p>
        <p>Professor: <?php echo $course['professor_name']; ?></p>
      </div>
    </a>
  <?php endforeach; ?>
</body>
</html>
