<!DOCTYPE html>
<html>
<head>
	<title>Class Dashboard</title>
	<link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
	<div class="container">
		<h1>Class Dashboard</h1>
		<?php

            session_start();  
            $user_id = $_SESSION['user_id'];  
			// Connect to the database
			$dbhost = "localhost";
			$dbname = "student_management_system";
			$dbuser = "postgres";
			$dbpass = "David910139";

			try {
				$conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				// Prepare a SQL query to retrieve class information
				$stmt = $conn->prepare("SELECT c.course_id, c.course_name, c.num_students, u.username AS professor_name 
				FROM courses c 
				JOIN users u ON c.id = u.id 
				WHERE c.id = :user_id 
				ORDER BY c.course_id");

				// Bind the user_id parameter to the prepared statement
				$stmt->bindParam(':user_id', $user_id);

				// Execute the prepared statement
				$stmt->execute();

				// Fetch the results as an associative array
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

				// Loop through the results and display them as class boxes
				foreach ($rows as $row) {
					echo "<div class='class-box'>";
					echo "<h2>" . $row['course_name'] . "</h2>";
					echo "<p>Class ID: " . $row['course_id'] . "</p>";
					echo "<p>Number of Students: " . $row['num_students'] . "</p>";
					echo "<p>Professor Name: " . $row['professor_name'] . "</p>";
					echo "</div>";
				}

				// Close the database connection
				$conn = null;
			} catch(PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
			}
		?>
	</div>
</body>
</html>
