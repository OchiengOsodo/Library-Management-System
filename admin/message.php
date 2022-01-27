<?php
  include "connection.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<head>
<title>Messages</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">

.form-control
    {
        height: 47px;
        width: 77%;
        background-color:#d8dcd6;
    }
    .msg
    {
        height: 450px;
        overflow-y: scroll;
    }
    .btn-info
    {
        background-color: #5edc1f;
    }
    .chat
    {
        display: flex;
        flex-flow: row wrap;

    }
    .user .chatbox
    {
        height: 50px;
        width: 400px;
        padding: 13px;
        background-color:#d8dcd6;
        border-radius: 32px;
        color: black;
        
  
    }
    .admin .chatbox
    {
        height: 50px;
        width: 400px;
        padding: 13px;
        background-color:#40e0d0;
        border-radius: 32px;
        order: -1;
        color: black;
  
    }
.left_box
{
    height:600px;
    width:500px;
    float:left;
    background-color:#24305e;
    margin-top:-20px;
}
.left_box2
{
    height: 600px;
    width: 300px;
    background-color:#f76c6c;
    border-radius:20px;
    float:right;
    margin-right:30px;
}
.left_box input
{
    width:150px;
    height:50px;
    background-color:white;
    padding:10px;
    margin:10px;
    border-radius:10px;
}
.list
{
    height:500px;
    width:300px;
    background-color:#f76c6c;
    float:right;
    color:white;
    padding:10px;
    overflow-y:scroll;
    overflow-x:hidden;
}
.right_box
{
    height:600px;
    width:1000px;
    margin-left:400px;
    padding:10px;
    background-color:#24305e ;
    margin-top:-20px;
}
.right_box2
{
    height: 600px;
    width:600px;
    margin-top:-20px;
    padding:20px;
    border-radius:20px;
    background-color:#f76c6c;
    float:left;
    color:white;
}
</style>

<body style="width: 1350px; height: 595px;">
<?php
$sql1=mysqli_query($db,"SELECT student.pic,message.username FROM student INNER JOIN message ON student.username=message.username group by username ORDER BY status ;");
?>

<!-------------left box-------------->
<div class="left_box">
    <div class="left_box2">
        <div>
            <form method="post" enctype="multipart/form-data">
            <input type="text" name="username" id="uname">
            <button type="submit" name="submit" class="btn btn-default">SHOW</button>
            </form>
        </div>
        <div class="list">
    <?php
            echo "<table id='table' class='table'>";
            while ($res1=mysqli_fetch_assoc($sql1))
            {
                echo "<tr>";
                    echo "<td width=65>"; echo "<img class='img-circle profile_img' height=60 width=60 src='images/".$res1['pic']."'>"; echo "</td>";

                
                    echo "<td style='padding-top:30px;'>"; echo $res1['username']; echo "</td>";
                echo "<tr>";
            }

            echo "</table>";
        ?>

        </div>

    </div>

</div>

<!---------------right box-------------->
<div class="right_box">
    <div class="right_box2">
        <?php
/*--------------if submit is pressed------------*/
            if(isset($_POST['submit']))
            {
                $res=mysqli_query($db,"SELECT * from message where username='$_POST[username]' ;");

                mysqli_query($db,"UPDATE message SET status='yes' where sender='student' and username='$_POST[username]' ;");

                if($_POST['username'] != ''){$_SESSION['username']=$_POST['username'];}

                ?>
                    <div style="height: 70px; width: 100%; text-align: center; color: white; ">
                    <h3 style="margin-top: -5px; padding-top: 10px;"> <?php echo $_SESSION['username'] ?> </h3>
                    </div>
<!------------show message-------------------->
        <div class="msg">
            <br>
        <?php
            while ($row=mysqli_fetch_assoc($res))
            {
                if($row['sender']=='student')
                {
        ?>
                            <!------------student------------>
            <br><div class="chat user">
                <div style="float: left; padding-top: 5px;">
                &nbsp
                <img style="height: 40px; width: 40px; border-radius: 50%;" src="images/icon.png">
            </div>
            &nbsp
            <div style="float: left; " class="chatbox">
            <?php
                echo $row['message'];
            ?>
            </div>
            </div>
            &nbsp
            <?php
                }
                else 
                {

            ?>
                            <!------------admin------------>
            <br><div class="chat admin">
                <div style="float: left; padding-top: 5px;">
                &nbsp
                <?php
                    echo "<img class='img-circle profile_img' height=40 width=40 src='images/".$_SESSION['pic']."'>";
                ?>
            </div>
            &nbsp
            <div style="float: left; " class="chatbox">
            <?php
                echo $row['message'];
            ?>
            </div>
        </div>
        <?php
            }
            }
        ?>
        </div>
                    <div style="height: 100px; padding-top:10px; ">
                        <form action="" method="post">
                        <input type="text" name="msg" class="form-control" required="" placeholder="Write Message..." style="float: left">&nbsp
                        <button class="btn btn-info btn-lg" type="submit" name="submit1"><span class="glyphicon glyphicon-send"></span>Send</button>
                        </form>
                    </div>
                    
                <?php
            } 
/*--------------if submit is not pressed------------*/
        else
        {
            if($_SESSION['username']=='')
            {
                ?>
                <img style="margin: 60px 20px; border-radius:50%;" src="images/text3.gif" alt="animated">
                <?php
            }
            else 
            {
                if(isset($_POST['submit1']))
                {
                    mysqli_query($db,"INSERT into `library`.`message` VALUES ('', '$_SESSION[username]', '$_POST[message]', 'no','admin');");
                    
                    $res=mysqli_query($db,"SELECT * from message where username='$_SESSION[username]' ;");
                }
            else 
            {
                $res=mysqli_query($db,"SELECT * from message where username='$_SESSION[username]' ;");
            }
                ?>
                    <div style="height: 70px; width: 100%; text-align: center; color: white; ">
                    <h3 style="margin-top: -5px; padding-top: 10px;"> <?php echo $_SESSION['username'] ?> </h3>
                    </div>

                    <div class="msg">
            <br>
        <?php
            while ($row=mysqli_fetch_assoc($res))
            {
                if($row['sender']=='student')
                {
        ?>
                            <!------------student------------>
            <br><div class="chat user">
                <div style="float: left; padding-top: 5px;">
                &nbsp
                <img style="height: 40px; width: 40px; border-radius: 50%;" src="images/icon.png">
            </div>
            &nbsp
            <div style="float: left; " class="chatbox">
            <?php
                echo $row['message'];
            ?>
            </div>
            </div>
            &nbsp
            <?php
                }
                else 
                {

            ?>
                            <!------------admin------------>
            <br><div class="chat admin">
                <div style="float: left; padding-top: 5px;">
                &nbsp
                <?php
                    echo "<img class='img-circle profile_img' height=40 width=40 src='images/".$_SESSION['pic']."'>";
                ?>
                
            </div>
            &nbsp
            <div style="float: left; " class="chatbox">
            <?php
                echo $row['message'];
            ?>
            </div>
        </div>
        <?php
            }
            }
        ?>
        </div>
        <div style="height: 100px; padding-top:10px; ">
                        <form action="" method="post">
                        <input type="text" name="msg" class="form-control" required="" placeholder="Write Message..." style="float: left">&nbsp
                        <button class="btn btn-info btn-lg" type="submit" name="submit1"><span class="glyphicon glyphicon-send"></span>Send</button>
                        </form>
                    </div>
                <?php
            }
        }
        ?>
    </div>
</div>
<script>
    var table = document.getElementById('table'),eIndex; for(var i=0; i< table.rows.length; i++)
    {
        table.rows[i].onclick =function()
    
        {
            rIndex = this.rowIndex;
            document.getElementById("uname").value = this.cells[1].innerHTML;
        }
    }   
</script>

</body>
</html>