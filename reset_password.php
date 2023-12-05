<?php
session_start();
include("signup_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = test_input($_POST["current_password"]);
    $new_password = test_input($_POST["new_password"]);
    $confirm_password = test_input($_POST["confirm_password"]);

    // Retrieve the user's current password from the database
    $stmt = $conn->prepare("SELECT password FROM signup_users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION["username"]);
    $stmt->execute();
    $stmt->bind_result($db_password);

    if ($stmt->fetch() && password_verify($current_password, $db_password)) {
        // Free the result set before executing another query
        $stmt->free_result();

        // Current password is correct, update the password
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE signup_users SET password = ? WHERE username = ?");
            $update_stmt->bind_param("ss", $hashed_password, $_SESSION["username"]);
            $update_stmt->execute();
            $update_stmt->close();

            // Provide feedback to the user
            header("Location:profile.php");
            echo "password updated successfully";
            exit();
        } else {
            $error_message = "New passwords do not match.";
        }
    } else {
        $error_message = "Current password is incorrect.";
    }

    $stmt->close();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES); // Sanitize output
    return $data;
}
?>

<!-- Add the password update form to this page -->
<!doctype html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- ... (your existing head content) ... -->
    <style>
        
        .error-message{
            color:red;
        }
        .success-message{
            color:green;
        }
        .form-box{
            background: linear-gradient(90deg, rgba(241,241,249,0.7063200280112045) 21%, rgba(246,247,252,1) 100%);
            border-radius: 8px;
            border:1px solid #041552;

        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <h1 class="row justify-content-center">Reset Password</h1>
            <div class="col-md-4 form-box">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" placeholder="Enter your current password" name="current_password">
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" placeholder="Enter your new password" name="new_password">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm your new password" name="confirm_password">
                    </div>

                    <?php if (isset($error_message)) : ?>
                        <div class="error-message">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary mt-4 mb-4">Update Password</button>
                    <a type="button" href="profile.php" class=" mt-4 mb-4 px-2">Back to profile</a>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
