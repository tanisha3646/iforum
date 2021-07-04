<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
    $showError="false";
    include '_dbconnect.php';
    $user=$_POST['loginName'];
    $email=$_POST['loginEmail'];
    $pass=$_POST['loginPassword'];
    echo $email;
    $sql="SELECT * FROM `users` WHERE user_email='$email' AND username='$user'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        if(password_verify($pass,$row['user_pass'])){
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['sno']=$row['sno'];
            $_SESSION['useremail']=$email;
            $_SESSION['username']=$user;
            header("Location:/forum/index.php?loginSuccess=true");
            exit();
        }
        else{
            $showError="Invalid Credentials";
        }
    }
    else{
        $showError="Unable to login";
        header("Location:/forum/index.php?loginSuccess=false&error=$showError");

    }
}
?>