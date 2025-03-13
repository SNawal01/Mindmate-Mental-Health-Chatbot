<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Forgot Password</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Reset Password</header>
            <?php 
            include("php/config.php");
            if(isset($_POST['submit'])){
                $email = strtolower(mysqli_real_escape_string($con, $_POST['email'])); // Convert email to lowercase

                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div class='message'><p>Invalid email format!</p></div><br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                } else {
                    $new_password = substr(md5(time()), 0, 8); // Generate a new 8-character password

                    // Check if email exists
                    $result = mysqli_query($con, "SELECT * FROM universitystudent WHERE Email='$email'");
                    if(mysqli_num_rows($result) > 0){
                        // Update the password in the database
                        mysqli_query($con, "UPDATE universitystudent SET Password='$new_password' WHERE Email='$email'")
                        or die("Error Occurred: " . mysqli_error($con));

                        echo "<div class='message'><p>Password reset successful! Your new password is: <b>$new_password</b></p></div><br>";
                        echo "<a href='login.php'><button class='btn'>Login Now</button></a>";
                    } else {
                        echo "<div class='message'><p>Email not found.</p></div><br>";
                        echo "<a href='forgot_password.php'><button class='btn'>Try Again</button></a>";
                    }
                }
            } else {
            ?>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Reset Password">
                </div>
                <div class="links">
                    Remembered your password? <a href="login.php">Login</a>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
