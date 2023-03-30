<!DOCTYPE html>
<html>
  <head>
    <title>Student Management System</title>
    <link rel="stylesheet" type="text/css" href="login.css">
  </head>
  <body>

    <?php
    session_start();
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Include the auth.php file to check the username and password
      include 'auth.php';
    }
    ?>
  
    <div class="login-container">
      <h1>Login</h1>
      
      <form method="post" action="">
        <?php
        // Check if the login attempt failed and display an error message
        if (isset($_GET['login_failed'])) {
          echo '<div class="error">Wrong username or password. Please try again.</div>';
        }
        ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
      </form>



    </div>
  </body>
</html>
