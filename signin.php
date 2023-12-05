<?php
session_start(); // Start the session
include("signup_connection.php"); // Include your database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    // Validate the username and password against the database
    $stmt = $conn->prepare("SELECT username, email, password, profile_image FROM signup_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_username, $db_email, $db_password, $db_profile_image);

    if ($stmt->fetch() && password_verify($password, $db_password)) {
        // Sign-in successful, store user details in session
        $_SESSION["username"] = $db_username;
        $_SESSION["email"] = $db_email;
        $_SESSION["profile_image"] = $db_profile_image;

        // Redirect to the user profile page
        header("Location: profile.php");
        exit();
    } else {
        $error_message = "please enter username and password";
    }

    $stmt->close();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>signin</title>
    <style>
        body {
            background-image: url('pictures/bg2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat:no-repeat;
        }
        .form-box{
            background: linear-gradient(90deg, rgba(241,241,249,0.7063200280112045) 21%, rgba(246,247,252,1) 100%);
            border-radius: 8px;
        }
        form a{
            text-decoration:none;
        }
        .error-message{
            color:red;
        }
      </style>
  </head>
  <body>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <div class="container mt-5">
        <div class="row justify-content-center ">
            <h1 class="row justify-content-center mt-5">Sign In</h1>
              <div class="col-md-4 form-box">
                <form method="post" action="" class="mt-3">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter your username"
                            name="username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter your password"
                            name="password">
                    </div>
                    <div class="mt-3">
                    <?php if (isset($error_message)) : ?>
                        <div class="error-message">
                       <?php echo $error_message; ?>
                       </div>
                    <?php endif; ?>
                    </div>
                  

                    <button type="submit" class="btn btn-primary mt-4">Sign In</button>

                    <div class="mt-3 ">
                        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                        
                    </div>
                </form>
            </div>
            
        </div>
    </div>
  </body>
</html>