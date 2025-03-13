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
   $query = mysqli_query($con, "SELECT * FROM universitystudent WHERE UserID=$id") or die(mysqli_error($con));
   $result = mysqli_fetch_assoc($query);
   if ($result) {
       $res_Uname = $result['Name'];
       $res_Email = $result['Email'];
       $res_Age = $result['Age'];
       $res_id = $result['UserID'];
   } else {
       die("User not found");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/homepage.css">
    <title>Home</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            position: sticky;
            top: 0;
        }
        footer {
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header>
        <div class="nav">
            <div class="logo">
                <p><a href="homepage.php">MindMate</a></p>
            </div>
            <div class="right-links">
                <a href="edit.php?Id=<?php echo $res_id; ?>"><button class="btn">Change Profile</button></a>
                <a href="php/logout.php"><button class="btn">Log Out</button></a>
            </div>
        </div>
    </header>
    <main>
       <div class="main-box">
          <div class="top">
            <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
          </div>
          <div class="bottom">
            <a href="index.php"><button class="btn">Chatbot</button></a>
          </div>
       </div>
    </main>
    <footer>
        <p> 2025 MindMate. All rights reserved.</p>
    </footer>
</body>
</html>