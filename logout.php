<?php

session_start();
if(isset($_SESSION['uniqe_id'])){
    include "confg.php" ;
    $logout_id=mysqli_real_escape_string($conn,$_GET["logout_id"]);
    if(isset($logout_id)){
        $status="offline now" ;
        $sql="UPDATE users SET status ='{$status}' WHERE uniqe_id={$logout_id} " ;
        $qry=$conn->query($sql);
        if($sql){
            session_unset();
            session_destroy();
            header("location:login.php");

        }
       
    } else{
        header("location:users.php");

    }
    
}
else{
    header("location:login.php");
}

?>