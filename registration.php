<?php
  include "connection.php";
  include "navbar.php";
  
?>

<!DOCTYPE html>
<html>
<head>

  <title>Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <style type="text/css">
    section
    {
      background-image: url("images/15.jpg");
      background-size: 1400px;
      height: 620px;
      margin-top: -20px;   
    }
    .box
    {
      height: 500px;
      width:450px;
      background-color:  #343434;
      margin: 0px auto;
      opacity: .7;
      color: white;
      padding: 20px;
      padding-top: 140px;
    }
    label 
    {
      font-weight: 600px;
      font-size: 18px;
    }
  </style>   
</head>
<body>

<section><br><br><br><br>
  <div class="box">
  <form  name="signup" action="" method="post">
        <b><p style="padding-left: 50px;font-size: 15px; font-weight: 700;">Sign Up as:</p></b>
        <input style="margin-left: 50px; width: 18px;" type="radio" name="user" id="admin" value="admin">
        <label for="admin">Admin</label>
        <input style="margin-left: 50px; width: 18px;" type="radio" name="user" id="student" value="student" checked="">
        <label for="student">Student</label>&nbsp&nbsp&nbsp&nbsp

        <button class="btn btn-default" type="submit" name="submit1" style="color: black; font-weight: 700; width: 70px; height: 30px;">Ok</button>
  </form>

  </div>
  <?php
    if(isset($_POST['submit1']))
    {
      if($_POST['user']=='admin')
      {
        ?>
          <script type="text/javascript">
            window.location="Admin/registration.php"
          </script>
        <?php
      }
      else
      {
        ?>
        <script type="text/javascript">
            window.location="Student/registration.php"
          </script>
        <?php
      }
    }


  ?>
</section>
  
</body>
</html>