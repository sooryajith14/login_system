<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: signin.php");
    exit();
}

// Retrieve user details from the session
$username = $_SESSION["username"];
$email = $_SESSION["email"];
$profile_image = $_SESSION["profile_image"];


// Check if the user clicked the sign-out button
if (isset($_POST["signout"])) {
    // Destroy the session
    session_destroy();
    // Redirect to the sign-in page after logout
    header("Location: signin.php");
    exit();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofI+Y9PSAc6TigBM8Hy5L5S" crossorigin="anonymous">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .profile-image {
            border-radius: 50%;
            border:1px solid white;
            width: 200px; 
            height: 200px; 
            object-fit: cover;
            margin: auto;
            display: block;
        }
        h2,p{
            color:white;
        }
        .div1-col{
            border: 1px solid #041552;
        }
        .div2-col{
            background-color:#041552;
        }
        .p1,h1{
            color:#041552;
        }
        .icon{
            color:#041552;
        }
    </style>
</head>
<body>
    <div class="container mt-5 text-center ">
        <div class="row div1-col">
            <div class="col-lg-8 ">
                <h1 class="mt-3">Profile</h1>
                <p class="p1 px-5 py-3">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                <button type="submit" class="btn btn-primary mt-3 mb-2" name="signout">Edit option</button>
                <p><a class="btn btn-primary mt-1 mb-5" href="reset_password.php">Reset Password</a></p>


            </div>
            <div class="col-lg-4 div2-col">
            <form method="post" action="">
                <img src="<?php echo $profile_image; ?>" class="mt-3 profile-image" alt="Profile Image">
                <h2 class="mt-3">Welcome, <?php echo $username; ?>!</h2>
                <p class="mt-3">Email: <?php echo $email; ?></p>
                <button type="submit" class="btn btn-primary mt-3 mb-5" name="signout">Sign Out</button>
            </form>
            </div>
        </div>    
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>