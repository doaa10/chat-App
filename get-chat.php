
<?php
session_start();
if(isset($_SESSION['uniqe_id'])){
    include "confg.php" ;

        $outgoing_id=mysqli_real_escape_string($conn,$_POST['outgoing_id']);
        $incoming_id=mysqli_real_escape_string($conn,$_POST['incoming_id']);


        $sql="SELECT * FROM messages LEFT JOIN users ON users.uniqe_id = messages.incoming_msg_id WHERE (outgoing_msg_id={$outgoing_id} AND incoming_msg_id={$incoming_id}) OR (outgoing_msg_id={$incoming_id} AND incoming_msg_id={$outgoing_id}) ORDER BY msg_id ";


        $output="";

        $qry=$conn->query($sql);
        if(!empty($qry)&&$qry->num_rows>0){
            while($row=$qry->fetch_array()){
                if($row['outgoing_msg_id']===$outgoing_id){ //if qual then he is a sender
                    $output.=' <div class="chat outgoing">
                    <div class="details">
                        <p>'.$row['msg'].'</p>
    
                    </div>
                </div>';
                }
                else{ //he is the receiver
                    $output.='<div class="chat incoming">
    
                        <img src="imgs/'.$row['img'].'">
                        <div class="details">
                            <p>'.$row['msg'].'</p>
    
                        </div>
                    </div>';
            }
            }
            echo $output;
           
        }
    
    }
       
  
else{
    header("location:login.php");

}


?>