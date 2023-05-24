<?php
include "confg.php" ;
session_start();
$output="";

   $searchTerm=mysqli_real_escape_string($conn,$_POST['searchTerm']);
    $sql="SELECT * FROM users WHERE fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%'";
    $qry=$conn->query($sql);
    
    if(!empty($qry) && $qry->num_rows>0){
        while($row=$qry->fetch_array()){

             //view the last send message 
             $outgoing_id=$_SESSION['uniqe_id'];
             $sql2="SELECT * FROM messages WHERE (incoming_msg_id={$row['uniqe_id']} OR outgoing_msg_id={$row['uniqe_id']} AND outgoing_msg_id={$outgoing_id} OR outgoing_msg_id={$outgoing_id}) ORDER BY msg_id DESC LIMIT 1 ";

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
    else{
    $output.="No users found related to ypur search term" ;
    }
echo $output;
    ?>



