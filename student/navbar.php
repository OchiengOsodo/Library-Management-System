<?php

  session_start();
  include "connection.php";

?>

<!DOCTYPE html>
<html>
<head>
	<title>
	</title>

	  <link rel="stylesheet" type="text/css" href="style.css">
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

</head>
<body>
<?php
if(isset($_SESSION['login_user']))
{

  $r=mysqli_query($db,"SELECT COUNT(status) as total FROM message where status='no' and username='$_SESSION[login_user]' and sender='admin' ;");

  $c=mysqli_fetch_assoc($r);

//-------------timer-------------
  $b=mysqli_query($db, "SELECT * from issue_book where username='$_SESSION[login_user]' and approve='Yes' ORDER BY `return` ASC limit 0,1 ;");
  
  $var1=mysqli_num_rows($b);
  
  $bid=mysqli_fetch_assoc($b);
  
  $t=mysqli_query($db, "SELECT * from `timer` where name='$_SESSION[login_user]' and bid='$bid[bid]' ;");
  $res=mysqli_fetch_assoc($t);

?>

	    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand active">LIBRARY MANAGEMENT SYSTEM</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="index.php">HOME</a></li>
            <li><a href="books.php">BOOKS</a></li>
            <li><a href="feedback.php">FEEDBACK</a></li>           
          </ul>
          <?php
           if($var1==1)
           {
          ?>

<!------------------timer---------------------->
<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $res['tm']; ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
<!------------------timer---------------------->
<?php } ?>
            <ul class="nav navbar-nav">
            <li><a href="fines.php">FINES</a></li>
            <li><a><p style="color: white; font-size:20px;" id="demo"></p></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <<li><a href="message.php"><span class="glyphicon glyphicon-envelope"></span>&nbsp
            <span class="badge bg-green"><?php echo $c['total'];?></span></a></li>
              <li><a href="profile.php">
                <div style="color:white">
                  <?php
                  echo "<img class='img-circle profile_img' height=50 width=50 src='images/".$_SESSION['pic']."'>";
                  echo " " .$_SESSION['login_user'];
                  ?>
                </div>
              </a></li>
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out">LOGOUT</span></li>

              </ul>

      </div>
    </nav>
    <?php
    if(isset($_SESSION['login_user']))
    {
      $day=0;
      $exp='<p style="color: black; background-color:beige;">EXPIRED</p>';
      $res=mysqli_query($db,"SELECT * FROM `issue_book` where username ='$_SESSION[login_user]' and approve ='$exp' ;");

      while($row=mysqli_fetch_assoc($res))
      {
        $d= strtotime($row['return']);
        $c= strtotime(date("Y-m-d"));
        $diff= $c-$d;

        if($diff>=0)
        {
          $day=$day+floor($diff/(60*60*24));
        } //days
        
      }
      $_SESSION['fine']=$day*.10;
    }}
else 
{?>
  <nav class="navbar navbar-inverse">
      <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand active">LIBRARY MANAGEMENT SYSTEM</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="index.php">HOME</a></li>
            <li><a href="books.php">BOOKS</a></li>
            <li><a href="feedback.php">FEEDBACK</a></li>  
          </ul>
          <ul class="nav navbar-nav navbar-right">

            <li><a href="../login.php"><span class="glyphicon glyphicon-log-in"> LOGIN</span></a></li>
            <li><a href="registration.php"><span class="glyphicon glyphicon-user"> SIGN UP</span></a></li>
          </ul>
      </div>
  </nav>
<?php
}
?>
</body>
</html>