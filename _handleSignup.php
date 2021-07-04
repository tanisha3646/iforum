<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
    $showError="false";
    include 'partials/_dbconnect.php';
    $username=$_POST['signupName'];
    $user_email=$_POST['signupEmail'];
    $pass=$_POST['signupPassword'];
    $cpass=$_POST['csignupPassword'];
    $showAlert=false;
    $namesql="SELECT * FROM `users` WHERE username='$username'";
    $result= mysqli_query($conn,$namesql);
    if(mysqli_num_rows($result)>0){
        $showError = "Username already exists";
    }
    else{
    //Check whether this email exists
        $existSql="SELECT * FROM `users` WHERE user_email='$user_email'";
        $result= mysqli_query($conn,$existSql);
        if(mysqli_num_rows($result)>0){
            $showError = "Email already registered";
        }
        else{
            if($pass==$cpass){
                $hash=password_hash($pass,PASSWORD_DEFAULT);
                $sql="INSERT INTO `users` (`username`,`user_email`, `user_pass`, `timestamp`) VALUES ('$username','$user_email', '$hash', current_timestamp())";
                $result=mysqli_query($conn,$sql);
                if($result){
                    $showAlert=true;
                    header("Location:/forum/index.php?signupSuccess=true");
                    exit();
                }
            }
            else{
                $showError = "Passwords does not match";
                
            }
        }
        
    }
    header("Location:/forum/index.php?signupSuccess=false&error=$showError");
    }


?>