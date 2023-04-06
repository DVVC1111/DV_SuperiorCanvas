<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// start the session
session_start();


$dbhost = "localhost";
$dbname = "student_management_system";
$dbuser = "postgres";
$dbpass = "David910139";

$conn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

// retrieve the course_id from the query parameter
$course_id = $_GET['course_id'];

// retrieve details of the selected course from the database
$stmt = $conn->prepare("SELECT c.course_name, u.username AS professor FROM courses c JOIN users u ON c.id = u.id WHERE c.course_id = :course_id");
$stmt->bindParam(':course_id', $course_id);
$stmt->execute();
$course = $stmt->fetch(PDO::FETCH_ASSOC);

// retrieve details of students enrolled in the selected course from the database
$stmt = $conn->prepare("SELECT sfname, slname FROM student WHERE course_id = :course_id");
$stmt->bindParam(':course_id', $course_id);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// store the course and student details in the session
$_SESSION['courses'] = $course;
$_SESSION['students'] = $students;
?>



<!DOCTYPE html>
<html>
  <head>
    <title>Class</title>
    <link rel="stylesheet" type="text/css" href="class_detail.css">
  </head>
  <body>
    <div class="container">
      <!-- display the course and student details -->
      <h2><?= $course['course_name'] ?></h2>
      <p>Professor: <?= $course['professor'] ?></p>
      <h3>Students</h3>
      <ul>
        <?php foreach ($students as $student): ?>
          <li>
            <p><?= $student['sfname'] ?> <?= $student['slname'] ?></p>
            <p class="grade">Grade: </p>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    
  </body>
</html>
