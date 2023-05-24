<?php
@include "confg.php" ;
session_start();
if(isset($_POST['submit'])){

    $fname=mysqli_real_escape_string($conn,$_POST['fname']);
    $lname=mysqli_real_escape_string($conn,$_POST['lname']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);

    $error=array();


    $select="SELECT * FROM users WHERE email='$email' AND password='$password'";

    $result=$conn->query($select);
    if(!$result){
        echo "error".$conn->error;
    }
    if(!empty($result) && $result->num_rows > 0){
        $error[]='user already exist!';
    }
    else{
        // if(isset($_FILES['image'])){
        //     $img_name=$_FILES['image']['name'];
        //     $img_type=$_FILES['image']['type'];
        //     $tmp_name=$_FILES['image']['tmp_name'];

        
        //     $image_extension=strtolower(end(explode('.',$img_name)));


        //     $extensions=['png','jpeg','jpg'];
        //     if(in_array($image_extension,$extensions)===true){
        //         $time=time(); //this will return the current time ,
        //         //we need this because when user uploading an image we rename his file with current time so all the imges will have a unique name
        //        $new_img_name=$time.$img_name;
        //        if(move_uploaded_file($tmp_name,"imgs/".$new_img_name) ){
        //         $status="ACTIVE now";
        //         $random_id=rand(time(),1000000);
        //        }

        //     }
        //     else{
        //         $error[]='please upload a valid image';
        //     }
        if(isset($_FILES['image'])){
            $img_name=$_FILES['image']['name'];
            $img_type=$_FILES['image']['type'];
            $tmp_name=$_FILES['image']['tmp_name'];


            $extensions=['png','jpeg','jpg'];

            $img_ext=explode('.',$img_name);
            $ext=strtolower(end($img_ext));
            

            if(in_array($ext,$extensions)){
                $time=time();
                $new_img_name=$time.$img_name;
                move_uploaded_file($tmp_name,"imgs//".$new_img_name);
                $status="ACTIVE NOW";
                $random_id=rand(time(),1000000);
            }else{
                $error[]= 'file is not valid';
            }

            

        }
        if(empty($error)){
            $insert ="INSERT INTO users (uniqe_id, fname, lname, email, password, img, status) VALUES ('$random_id', '$fname', '$lname', '$email', '$password', '$new_img_name', '$status')
            " ;
               $qry= $conn->query($insert);
               $sql3="SELECT * FROM users WHERE email='$email'";
               $exec=$conn->query($sql3);
               if($exec->num_rows>0){
                $row=$exec->fetch_array();
                $_SESSION['uniqe_id']=$row['uniqe_id'];
               }
               
                header('location:users.php');

        }
      

           }

        }
             
        
    
;

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
            <form action="" method="post" enctype="multipart/form-data">
            
           <?php
           if(isset($error)){
               foreach($error as $error){
                   echo '<span class="error-msg">'.$error.'</span>';
               }
           };
       ?>
                    

                <div class="detail">
                   <div class="name-details">
                    <div class="field">
                        <label>First Name</label>
                        <input type="text" name="fname" placeholder="first name" required>
                    </div>

                    <div class="field">
                        <label>Last Name</label>
                        <input type="text" name="lname" placeholder="Last name" required>
                    </div>
                   </div>
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="enter your email" required>
                    </div>

                    <div class="field">
                        <label>password</label>
                        <input type="password" name="password" required placeholder="enter your password">
                    </div>
                    <div class="upload">
                        <label>select image</label>
                        <input type="file" name="image" required>
                    </div>
                    <div class="submit button">
                        <input class="btn" type="submit" name="submit" value="continue to chat">
                    </div>
                    <div class="footer">
                        <span>Already signed up ?</span>
                        <a href="login.php">Login now</a>
                    </div>

                </div>





            </form>


        </div>
    </div>

</body>
</html>