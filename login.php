
<?php
@include "confg.php";
session_start();

if(isset($_POST["submit"])){
$email=mysqli_real_escape_string($conn,$_POST["email"]);
$password=mysqli_real_escape_string($conn,$_POST["password"]);

$select="SELECT * FROM users WHERE email='$email' AND password='$password'";
$result=$conn->query($select);

if(!empty($result)&&$result->num_rows>0){
    $row=$result->fetch_array();
    $_SESSION['uniqe_id']=$row['uniqe_id'];

        $status="ACTIVE NOW";
        $sql="UPDATE users SET status ='{$status}' WHERE uniqe_id={$row['uniqe_id']} " ;
        $qry=$conn->query($sql);
        if($qry){
            $_SESSION['uniqe_id']=$row['uniqe_id'];
            echo "sss" ;
        }
        header("location:users.php");
}
else{
    $error[]="incorrect email or password";
}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat app</title>
    <link rel="stylesheet" href="style2.css" >

</head>
<body>
    <div class="wrapper">
        <div class="signup form">
            <h1 class="title">RealTime Chat App</h1>
            <form action=""  method="post">
            <?php
           if(isset($error)){
               foreach($error as $error){
                   echo '<span class="error-msg">'.$error.'</span>';
               }
           };
       ?>
                <div class="detail">                            
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email"  required placeholder="enter your email">
                    </div>

                    <div class="field">
                        <label>password</label>
                        <input type="password" name="password"  required placeholder="enter your password">
                    </div>
                    
                    <div class="submit">
                        <input type="submit" name="submit" value="continue to chat">
                    </div>
                    <div class="footer">
                        <span>don't have an account yet ? </span>
                        <a href="signup.php">signup now</a>
                    </div>

                </div>

            </form>


        </div>
    </div>
    
</body>
</html>