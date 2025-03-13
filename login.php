<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php 
              include("php/config.php");

              // Check if form is submitted
              if (isset($_POST['submit'])) {
                // Get form data
                $email = strtolower(mysqli_real_escape_string($con, $_POST['email'])); // Convert email to lowercase
                $password = $_POST['password']; // Password entered by the user

                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div class='message'><p>Invalid email format!</p></div><br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                } else {
                    // Query the database to get user by email
                    $result = mysqli_query($con, "SELECT * FROM universitystudent WHERE Email='$email'") or die("Select Error");

                    // Fetch the user data
                    $row = mysqli_fetch_assoc($result);

                    // Check if a user is found
                    if ($row) {
                        $storedPassword = $row['Password'];  // The stored password from the database

                        // Verify the entered password with the stored password
                        if ($password === $storedPassword) {
                            // Password matches, set session variables
                            $_SESSION['valid'] = $row['Email'];
                            $_SESSION['age'] = $row['Age'];
                            $_SESSION['id'] = $row['UserID'];

                            // Redirect to homepage
                            header("Location: homepage.php");
                            exit();
                        } else {
                            echo "<div class='message'><p> Incorrect password.</p></div><br>";
                        }
                    } else {
                        echo "<div class='message'><p> Email not found.</p></div><br>";
                    }

                    echo "<a href='login.php'><button class='btn'>Go Back</button></a>";
                }
            } else {
            ?>

            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
                <div class="links">
                    Forgot your password? <a href="forgot_password.php">Reset Password</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>
