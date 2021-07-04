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
    #ques {
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
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE category_id=$id";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $catname=$row['category_name'];
        $catdesc=$row['category_description'];
    }
    ?>
    <?php
    $showAlert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method=="POST"){
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        //Insert data into db
        $th_title=$_POST['title'];
        $th_title=str_replace("<","&lt;",$th_title);
        $th_title=str_replace(">","&gt;",$th_title);
        $th_desc=$_POST['desc'];

        $th_desc=str_replace("<","&lt;",$th_desc);
        $th_desc=str_replace(">","&gt;",$th_desc);

        $sno=$_POST["sno"];
        $sql="INSERT INTO `threads` (`thread_title`,`thread_desc`,`thread_cat_id`,`thread_user_id`,`timestamp`) VALUES ('$th_title','$th_desc','$id','$sno',current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Concern has been added successfully! Please wait for the community to Respond.
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

    <div class="container my-4" style="backgroud_color:cyan;" id="me">
        <div class="jumbotron ">
            <h1 class="display-4">Welcome to <?php echo $catname ?> forums</h1>
            <p class="lead"><?php echo $catdesc ?></p>
            <hr class="my-4">
            <p><i>This is apeer to peer forum for shring knowledege with each other.No Spam / Advertising / Self-promote
                    in
                    the forums is allowed. Do not post copyright-infringing material. Do not post “offensive” posts,
                    links
                    or images. Do not cross post questions. Do not PM users asking for help. Remain respectful of other
                    members at all times.</i></p>
            
        </div>
    </div>

    <div class="container">
        <h1 class="py-2 my-3">Start a discussion</h1>
        <form action="<?php $_SERVER["REQUEST_URI"] ?>" method="post">
            <div class="form-floating">
                <input class="form-control" placeholder="Leave a comment here" id="title" name="title" style=" height:
                    60px;">
                <label for="floatingTextarea2">Give a title to your concern</label>
                <div id="emailHelp" class="form-text">Keep Your title short and crisp!</div>
            </div>
            <input type="hidden" name="sno" value="<?php echo $_SESSION['sno']?>">
            <br>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="desc" name="desc" style=" height:
                    100px;"></textarea>
                <label for="floatingTextarea2">Elaborate Your concern!</label>
            </div>

            <button type="submit" class="btn btn-success my-4">Submit</button>
        </form>
    </div>


    <div class="container my-4 mb-5" id="ques">
        <h1 class="py-2 my-3">Browse Questions</h1>

        <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
    $result=mysqli_query($conn,$sql);
    $noresult=true;
    while($row=mysqli_fetch_assoc($result)){
        $noresult=false;
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $id=$row['thread_id'];
        $thread_time=$row['timestamp'];
        $thread_user_id=$row['thread_user_id'];
        $sql2="SELECT username  from `users` WHERE sno=$thread_user_id";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        

        echo '<div class="media my-4" id="mee">
            <img class="mr-3" src="img/userdefault.jpg" width=44px alt="Generic placeholder image">
            <div class="media-body" id="x">
                <h5 class="mt-0"> <a class="text-dark" href="threads.php?thread_id='.$id.'"> '. $title.'</a></h5>
                '.$desc.'
            </div>' . '<p class="my-0">Concern By: <b>'.$row2["username"].' at '. $thread_time .'</b></p> '.'
        </div>';
    }
    if($noresult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4 text-center">No Threads so far</h1>
          <p class="lead text-center"><b> Be the first person to ask a question </b></p>
        </div>
      </div>';

    }
    ?>
    </div>
    <!-- <div class="media my-4">
            <img class="mr-3" src="img/userdefault.jpg" width=54px alt="Generic placeholder image">
            <div class="media-body">
                <h5 class="mt-0"> <a class="text-dark" href="thread.php"> Hi</a> </h5>
                xxxx
            </div>
        </div> -->


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