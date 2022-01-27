<?php
  include "connection.php";
  include "navbar.php";
?>

<!DOCTYPE html>
<html>
<head>

  <title>Student Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 
  <style type="text/css">
    section
    {
      margin-top: -20px;
    }
    .box1
    {
      height: 500px;
      width:450px;
      background-color: black;
      margin: 0px auto;
      opacity: .7;
      color: beige;
      padding: 20px;
    }
    .alert 
    {
      margin: 80px auto;
    }
  </style>   
</head>
<body>

<section>
  <div class="log_img">
   <br>
    <div class="box1">
        <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console;">Library Management System</h1>
        <h1 style="text-align: center; font-size: 25px;">User Login Form</h1><br>
      <form  name="login" action="" method="post">
        <b><p style="padding-left: 50px;font-size: 15px; font-weight: 700;">Login as:</p></b>
        <input style="margin-left: 50px; width: 18px;" type="radio" name="user" id="admin" value="admin">
        <label for="admin">Admin</label>
        <input style="margin-left: 50px; width: 18px;" type="radio" name="user" id="student" value="student" checked="">
        <label for="student">Student</label>
        
        <div class="login">
          <input class="form-control" type="text" name="username" placeholder="Username" required=""> <br>
          <input class="form-control" type="password" name="password" placeholder="Password" required=""> <br>
          <input class="btn btn-default" type="submit" name="submit" value="Login" style="color: black; width: 70px; height: 30px"> 
        </div>
      
      <p style="color: white; padding-left: 15px;">
        <br><br>
        <a style="color:white;" href="update_password.php">Forgot password?</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
        New to this website? &nbsp <a style="color: white;" href="registration.php">Sign Up</a>
      </p>
    </form>
    </div>
  </div>
</section>

  <?php

    if(isset($_POST['submit']))
    {
      if($_POST['user']=='admin')
      {
        $count=0;
      $res=mysqli_query($db,"SELECT * FROM `admin` WHERE username='$_POST[username]' and password='$_POST[password]' and status='yes';");
      $row=mysqli_fetch_assoc($res);
      $count=mysqli_num_rows($res);

      if($count==0)
      {
        ?>
          <div class="alert alert-danger" style="text-align: center; width: 370px; margin-left: 500px; background-color: #de1313; color: white">
            <strong>The username and password doesn't match</strong>
          </div>    
        <?php
      }
      else
      {
        /*------------if username & password matches------*/
        $_SESSION['login_user'] = $_POST['username']; 
        $_SESSION['pic']= $row['pic'];
        $_SESSION['username']= '';

        ?>

          <script type="text/javascript">
            window.location="Admin/profile.php"
          </script>

        <?php
      }
      }
      else 
      {
      $count=0;
      $res=mysqli_query($db,"SELECT * FROM `student` WHERE username='$_POST[username]' && password='$_POST[password]';");
      
      $row=mysqli_fetch_assoc($res);
      $count=mysqli_num_rows($res);

      if($count==0)
      {
        ?>
          <div class="alert alert-danger" style="text-align: center; width: 370px; margin-left: 500px; background-color: #de1313; color: white">
            <strong>The username and password doesn't match</strong>
          </div>    
        <?php
      }
      else
      {
        if($row['status']==1)
        {$_SESSION['login_user'] = $_POST['username']; 
        $_SESSION['pic']= $row['pic'];
        ?>
          <script type="text/javascript">
            window.location="Student/profile.php"
          </script>
        <?php
      }
      else 
      {
        ?>
          <script type="text/javascript">
            alert ("Verify your email address by OTP before Login")
          </script>
        <?php
      }
      }
    }
  }
  ?>

</body>
</html>