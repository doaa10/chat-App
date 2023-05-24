<?php

$conn=new mysqli("localhost","root","","chatApp");

if($conn->connect_error){
    echo "error".$conn->connect_error ;
}




?>