<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <style>
            #ques{
            min-height: 433px;
        }
        #me {
        background-color: lightgrey;
        padding: 40px;
    }

    #mee {
        display: flex;
        justify-content: left;
        align-items: left;
        margin: 10px;
    }

    #mee img {
        width: 50px;
        height: 50px;
        margin-top:10px;
    }

    #x {
        margin-left: 10px;
        
    }
        </style>
    <title>Welcome to Let's Discuss - Coding Forums</title>
</head>

<body>
    <?php include "partials/_dbconnect.php";?>
    <?php require "partials/_header.php";?>
    <?php
    $id=$_GET['thread_id'];
    $sql="SELECT * FROM `threads` WHERE thread_id=$id";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_user_id=$row['thread_user_id'];

        //Qurey the users table to find the no name of the op
        $sql2="SELECT username  from `users` WHERE sno=$thread_user_id";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $posted_by=$row2['username'];
    }
    ?>

<?php

$showAlert=false;
$method=$_SERVER['REQUEST_METHOD'];
if($method=="POST"){
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        //Insert data into comment db
        $comment=$_POST['comment'];
        $comment= str_replace("<","&lt;",$comment);
        $comment= str_replace(">","&gt;",$comment);
        $sno=$_POST["sno"];
        $sql="INSERT INTO `comments` ( `comment_by`, `comment_content`, `thread_id`, `comment_time`) VALUES ( '$sno', '$comment', '$id', current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Comment has been added successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    }
    else{
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>You are not LoggedIn!</strong> Please Login to continue.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}

?>


    <div class="container my-4" id="me">
        <div class="jumbotron ">
            <h1 class="display-4 "> <b><?php echo $title ?></b></h1>
            <p class="lead"><?php echo $desc ?></p>
            <hr class="my-4">
            <p><i>This is apeer to peer forum for shring knowledege with each other.No Spam / Advertising / Self-promote in
                the forums is allowed. Do not post copyright-infringing material. Do not post “offensive” posts, links
                or images. Do not cross post questions. Do not PM users asking for help. Remain respectful of other
                members at all times.</i></p>
            <p><i>Posted By:  </i><b><?php echo $posted_by;?></b></p>
        </div>
    </div>
    <div class="container">
        <h1 class="py-2 my-3">Post a Comment</h1>
        <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
            
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="comment" name="comment" style=" height:
                    100px;"></textarea>
                <label for="floatingTextarea2">Type Your comment!</label>
    <input type="hidden" name="sno" value="<?php echo $_SESSION['sno']?>">

            </div>

            <button type="submit" class="btn btn-success my-4">Post Comment</button>
        </form>
    </div>
    <div class="container my-4 mb-5" id="ques">
        <h1 class="py-2 my-3">Discussions</h1>

    <?php
    $id=$_GET['thread_id'];
    $sql="SELECT * FROM `comments` WHERE thread_id=$id";
    $result=mysqli_query($conn,$sql);
    $noresult=true;
    while($row=mysqli_fetch_assoc($result)){
        $noresult=false;
        $content =$row['comment_content'];
        $comment_time =$row['comment_time'];
        $id=$row['comment_id'];
        $thread_user_id=$row['comment_by'];
        $sql2="SELECT username  from `users` WHERE sno=$thread_user_id";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);

        echo '<div id="mee">
        <img src="img/userdefault.jpg" width="54px"  alt="...">
        <div class="media-body" id="x">
        <p class="my-0"><b>'.$row2["username"].' at '. $comment_time .'</b></p> 
       <p>'. $content . '</p>
        </div>
    </div>'
        ;
    }
    if($noresult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4 text-center">No Comment so far</h1>
          <p class="lead text-center"><b> Be the first person to Post a comment </b></p>
        </div>
      </div>';

    }
    ?>
    </div>

<?php require "partials/_footer.php";?>



        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
        </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
</body>

</html>