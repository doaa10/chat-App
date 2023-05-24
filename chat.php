
<?php
session_start();
if(!isset($_SESSION['uniqe_id'])){

    header("location:login.php");

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>
<body>
    <div class="wrapper">
        <div class="chat-area">
            <header>
            <?php
                include "confg.php";
                $user_id=mysqli_real_escape_string($conn,$_GET['user_id']);
                    $sql="SELECT * FROM users WHERE uniqe_id={$user_id}";
                    $qry=$conn->query($sql);
                    if(!empty($qry)&&$qry->num_rows>0){
                        $row=$qry->fetch_array();
                    }
                    else{
                        echo "failed";
                    }
                ?>
                <a href="users.php" class="back-icon"><i class="bi bi-arrow-left"></i></a>
                <img src="imgs/<?php echo $row['img']?>">
                <div class="details">
                        <span> <?php 
                       echo  $row['fname']." ".$row['lname'] ;
                        ?></span>
                        <p> <p><?php
                        echo $row['status'];
                        ?></p></p>
                    </div>
                </div>
            </header>
                <div class="chat-box">
                   
                   

                    
                </div>

                <form action="" class="typing-area" method="post" name="form">
                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['uniqe_id'] ?>" hidden>   
                <input type="text" name="incoming_id" value="<?php echo $user_id ?>" hidden >   

                <input type="text" class="input-field" name="message" placeholder="type a message here...">
                
                
                    <button><i class="bi bi-send-fill"></i></button>
                </form>
        </div>

    </div>
    <script src="insert-chat.js"></script>

    
</body>
</html>