<?php
    include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify email address</title>
    <style type="text/css">
body 
{
    background-image: url("images/20.jpg");
    background-size: 1400px;
    background-repeat: no-repeat;
    font-family: "Lato", sans-serif;
    transition: background-color .5s;
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
    </style>
</head>
<body>
<div class="box1">
    <h2>Enter OTP:-</h2>
    <form method="post">
        <input style="height: 50px;" type="text" name="otp" class="form-control" required="" placeholder="Enter the OTP here.."><br>
        <button class="btn btn-default" type="submit" name="submit_v" style="font-weight:700;">Verify</button>
    </form>
</div>
<?php
$ver1=0;
if(isset($_POST['submit_v']))
{
    $ver2=mysqli_query($db, "SELECT * FROM verify;");
    while($row= mysqli_fetch_assoc($ver2))
    {
        if($_POST['otp']==$row['otp'])
        {
            mysqli_query($db, "UPDATE student set status='1' where username='$row[username]' ;");
            $ver1=$ver1+1;
        }

    }
    if($ver1==1)
    {
        header("location:login.php");
    }
    else
    {
        ?>

          <script type="text/javascript">
            alert ("Wrong OTP given.");
          </script>
        <?php
    }

}
?>
</body>
</html>