<?php
  include "connection.php";
  include "navbar.php";
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Book Request</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
.srch
{
	padding-left: 800px;
}
.form-control
{
  width:300px;
}
body 
{
    background-image: url("images/15.jpg");
    background-size: 1500px;
    background-repeat: no-repeat;
    font-family: "Lato", sans-serif;
    transition: background-color .5s;
}

.sidenav {
  height: 100%;
  margin-top: 50px;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #222;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
  color:white;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
.img-curl_multi_close
{
	margin-left: 20px;
}
.container
{
  height:500px;
  background-color:black;
  opacity:.7;
  color: white;
}
.scroll
{
  width:100%;
  height:500px;
  overflow:auto;
}
.th,td
{
  width:10%;
}

</style>
</head>
<body>
<!--_________________________sidenav_____________________-->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  	<div style="color:white; margin-left: 60px; font-size: 20px;">
                  <?php
				  if(isset($_SESSION['login_user']))
				  {
                  echo "<img class='img-circle profile_img' height=120 width=120 src='images/".$_SESSION['pic']."'>";
				  echo "</br></br>";
                  echo "Welcome " .$_SESSION['login_user'];
				  }
                  ?>
	</div> 

  <div class="h"><a href="add.php">Books</a></div>
  <div class="h"><a href="request.php">Book Request</a></div>
  <div class="h"><a href="issue_info.php">Issue Information</a></div>
  <div class="h"><a href="expired.php">Expired List</a></div>
</div>

<div id="main">
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;<b>Open</b></span>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "white";
}
</script>
<div class="container">
<form style="padding-top: 20px;" method="post">
<button class="btn btn-default" style="float: left; background-color: #7fff00; color: black;" name="submit_m" type="submit"><b>Send Email</b></button>
</form>
<h3 style="text-align: center;"><b>Information of Borrowed Books</b></h3>
<?php
$c=0; $sql="SELECT student.username,roll,books.bid,name,authors,edition,issue,issue_book.return FROM student inner join issue_book ON student.username=issue_book.username inner join books ON issue_book.bid=books.bid WHERE issue_book.approve ='Yes'  
  ORDER BY `issue_book`.`return` ASC";
  $res=mysqli_query($db,$sql);

    echo "<table class='table table-bordered' style='width:100%;'>";
    echo "<tr style='background-color: #E62020; color:black;'>";
      //Table header
      
      echo "<th>"; echo "Username";	echo "</th>";
      echo "<th>"; echo "Roll No";  echo "</th>";
      echo "<th>"; echo "BID";  echo "</th>";
      echo "<th>"; echo "Book Name";  echo "</th>";
      echo "<th>"; echo "Authors Name";  echo "</th>";
      echo "<th>"; echo "Edition";  echo "</th>";
      echo "<th>"; echo "Issue Date";  echo "</th>";
      echo "<th>"; echo "Return Date";  echo "</th>";
    
    echo "</tr>";	
    echo "</table>";

    echo "<div class='scroll'>";
    echo "<table class='table table-bordered'>";
    while($row=mysqli_fetch_assoc($res))
    {
      $d=date("Y-m-d");
      if($d > $row['return'])
      {
        $c=$c+1;
        $var='p style="color:black; background-color:#E62020;">EXPIRED</p>';
        mysqli_query($db, "UPDATE issue_book SET approve='$var' where `return`='$row[return]' and approve='Yes' limit $c;");
        echo $d."</br>";
      }
      echo "<tr>";
      echo "<td>"; echo $row['username']; echo "</td>";
      echo "<td>"; echo $row['roll']; echo "</td>";
      echo "<td>"; echo $row['bid']; echo "</td>";
      echo "<td>"; echo $row['name']; echo "</td>";
      echo "<td>"; echo $row['authors']; echo "</td>";
      echo "<td>"; echo $row['edition']; echo "</td>";
      echo "<td>"; echo $row['issue']; echo "</td>";
      echo "<td>"; echo $row['return']; echo "</td>";
      
      echo "</tr>";
    }
  
  echo "</table>";
  echo "</div>";
  if(isset($_POST['submit_m']))
  {
    $t=mysqli_query($db,"SELECT * FROM `issue_book` WHERE approve='yes';");
    $date1=date_create(date("Y-m-d"));
    while($row=mysqli_fetch_assoc($t))
    {
      $date2=date_create($row['return']);
      $diff=date_diff($date1,$date2);
      $day=$diff->format("%a");
      if($day==2)
      {
        $name_m=$row['username'];
        $bid_m=$row['bid'];
        $sql_m=mysqli_query($db, "SELECT * FROM `student` WHERE username='$row[username]';");
        $to=mysqli_fetch_assoc($sql_m);
        $subject="Regarding book return date";
        $msg="Hello!
              This is sent to notify that you need to return the book (Id: ".$bid_m.") in two days.";
        $from="From: andyosodo@gmail.com";
        if(mail($to['email'], $subject, $msg, $from))
        {
          ?>
            <script type="text/javascript">
            alert ("Mail sent successfully.")
            </script>
          <?php
        }
        else 
        {
          ?>
          <script type="text/javascript">
          alert ("Mail not sent.")
          </script>
        <?php
        }
      }
    }
  }
?>
</div>
</div>
</body>
</html>