<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
    exit();
   }

   $id = $_SESSION['id'];
   if (!is_numeric($id)) {
       die("Invalid User ID");
   }

   // Fetch user data
   $query = mysqli_query($con, "SELECT * FROM universitystudent WHERE UserID=$id") or die(mysqli_error($con));
   $result = mysqli_fetch_assoc($query);

   if (!$result) {
       die("User not found");
   }

   if (isset($_POST['submit'])) {
       $name = mysqli_real_escape_string($con, $_POST['name']);
       $email = strtolower(mysqli_real_escape_string($con, $_POST['email'])); // Convert email to lowercase

       // Validate email format
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           echo "<div class='message'><p>Invalid email format!</p></div><br>";
           echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
       } else {
           $age = mysqli_real_escape_string($con, $_POST['age']);
           $mobilenumber = mysqli_real_escape_string($con, $_POST['mobilenumber']);
           $emergencymobilenumber = mysqli_real_escape_string($con, $_POST['emergencymobilenumber']);
           $password = mysqli_real_escape_string($con, $_POST['password']); // Remove password hashing

           // Update user data
           mysqli_query($con, "UPDATE universitystudent SET Name='$name', Email='$email', Age='$age', MobileNumber='$mobilenumber', EmergencyMobileNumber='$emergencymobilenumber', Password='$password' WHERE UserID=$id")
           or die("Error Occurred: " . mysqli_error($con));

           echo "<div class='message'><p>Profile updated successfully!</p></div><br>";
       }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Change Profile</title>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <header>Change Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $result['Name']; ?>" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $result['Email']; ?>" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $result['Age']; ?>" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="mobilenumber">Mobile Number</label>
                    <input type="number" name="mobilenumber" id="mobilenumber" value="<?php echo $result['MobileNumber']; ?>" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="emergencymobilenumber">Emergency Mobile Number</label>
                    <input type="number" name="emergencymobilenumber" id="emergencymobilenumber" value="<?php echo $result['EmergencyMobileNumber']; ?>" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" value="<?php echo $result['Password']; ?>" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update Profile">
                </div>
                <div class="field">
                    <a href="homepage.php" class="btn">Home</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
