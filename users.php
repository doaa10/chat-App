<?php
session_start();
if(!isset($_SESSION['uniqe_id'])){
    header("location:login.php");
}
?>

        <?php
        include "confg.php";
        $output="";
        $sql="SELECT * FROM users";
        $qry=$conn->query($sql);
        if(empty($qry)&&$qry->num_rows==1){
            $output.="No users are available to chat";
        }
        elseif(!empty($qry) && $qry->num_rows>0){
                while($row=$qry->fetch_array()){

                    //view the last send message 
                    $outgoing_id=$_SESSION['uniqe_id'];
                    $sql2="SELECT * FROM messages WHERE (incoming_msg_id={$row['uniqe_id']} OR outgoing_msg_id={$row['uniqe_id']}) AND (outgoing_msg_id={$outgoing_id} OR outgoing_msg_id={$outgoing_id}) ORDER BY msg_id DESC LIMIT 1 ";

                    $qry2=$conn->query($sql2);
                    $row2=$qry2->fetch_array();
                    if(!empty($qry2)&& $qry2->num_rows>0){
                        $result=$row2['msg'];
                    }
                    else{
                        $result="NO message available";
                    }
                    (strlen($result)>28) ? $msg=substr($result,0,28).'...' :$msg=$result ;
                    ($outgoing_id==$row2['outgoing_msg_id']) ?$you ="You: " :$you="";


                    //check if the user is online or offline

                    ($row['status']=="offline now") ? $offline="offline" : $offline="";

                    $output.='<a href="chat.php?user_id='.$row['uniqe_id'].'">
                    <div class="contnet">
                        <img src="imgs/'.$row['img'].'">
                        <div class="details">
                            <span>'.$row['fname']." ".$row['lname'].'</span>
                            <p>'.$you.$msg.'</p>
                        </div>
                    </div>
                    <div class="status-dot '.$offline.'"><i class="bi bi-circle-fill"></i></div>
                </a>';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>
<body>
    <div class="wrapper">
        <div class="users">
            <header>
                <?php
                include "confg.php";
                    $sql="SELECT * FROM users WHERE uniqe_id={$_SESSION['uniqe_id']}";
                    $qry=$conn->query($sql);
                    if(!empty($qry)&&$qry->num_rows>0){
                        $row=$qry->fetch_array();
                    }
                    else{
                        echo "failed";
                    }
                ?>

                <div class="content">
                    <img src="imgs/<?php echo $row['img']?>">

                    <div class="details">
                        <span>
                        <?php 
                       echo  $row['fname']." ".$row['lname'] ;
                        ?>
                        </span>
                        <p><?php
                        echo $row['status'];
                        ?></p>
                    </div>

                </div>
                <a href="logout.php?logout_id=<?php echo $row['uniqe_id']?>" class="logout">Logout</a>
            </header>

            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input name="searchTerm" class="se" type="text" placeholder="Enter name to search">
            <button  name="search" class="click"><i class="bi bi-search"></i></button>
            
            </div>
     
            <div class="users-list">
                
                    <?php
                    echo $output;               
                    ?>
                    <?php
        include "search.php";
                    ?>
            </div>

        </div>
    </div>
    <script src="users2.js"></script>
    
</body>
</html>