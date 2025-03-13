<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Sign Up</header>
            <?php 
            include("php/config.php");
            if(isset($_POST['submit'])){
                $name = $_POST['name'];
                $email = strtolower($_POST['email']); // Convert email to lowercase
                $age = $_POST['age'];
                $mobilenumber = $_POST['mobilenumber'];
                $emergencymobilenumber = $_POST['emergencymobilenumber'];
                $password = $_POST['password']; // Remove password hashing

                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div class='message'><p>Invalid email format!</p></div><br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                } 
                // Validate password length
                else if(strlen($_POST['password']) < 8){
                    echo "<div class='message'><p>Password must be at least 8 characters long!</p></div><br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                } 
                // Validate mobile numbers
                else if($mobilenumber == $emergencymobilenumber){
                    echo "<div class='message'><p>Mobile number and emergency mobile number cannot be the same!</p></div><br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                } 
                else {
                    // Check if email already exists
                    $verify_query = mysqli_query($con, "SELECT Email FROM universitystudent WHERE Email='$email'");
                    if(mysqli_num_rows($verify_query) != 0){
                        echo "<div class='message'><p>This email is already used, Try another one!</p></div><br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                    } else {
                        // Insert into User table first
                        mysqli_query($con, "INSERT INTO User (Category, Name) VALUES ('Student', '$name')");
                        $userID = mysqli_insert_id($con); // Get the last inserted UserID

                        // Now insert into UniversityStudent
                        mysqli_query($con, "INSERT INTO universitystudent (UserID, Name, Age, Email, MobileNumber, EmergencyMobileNumber, Password) 
                        VALUES ('$userID', '$name', '$age', '$email', '$mobilenumber', '$emergencymobilenumber', '$password')")
                        or die("Error Occurred: " . mysqli_error($con));

                        echo "<div class='message'><p>Registration successful!</p></div><br>";
                        echo "<a href='login.php'><button class='btn'>Login Now</button></a>";
                    }
                }
            } else {
            ?>
            <form action="" method="post">
                <div class="field input">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="mobilenumber">Mobile Number</label>
                    <input type="number" name="mobilenumber" id="mobilenumber" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="emergencymobilenumber">Emergency Mobile Number</label>
                    <input type="number" name="emergencymobilenumber" id="emergencymobilenumber" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register">
                </div>
                <div class="links">
                    Already a member? <a href="login.php">Sign In</a>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>