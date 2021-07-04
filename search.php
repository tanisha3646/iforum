<!Doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <style>
            .container{
                min-height:80vh;
        }
        #me{
            text-decoration:None;
        }
        #me:hover{
            text-decoration:Underline;
        }
        </style>

    <title>Welcome to Let's Discuss - Coding Forums</title>
</head>

<body>

<?php include "partials/_dbconnect.php";?>
    <?php require "partials/_header.php";?>


 <!-- //Search results start here -->
<div class="container my-4">
    <h1 class="py-3">Search results for <em>"<?php echo $_GET['search']?>"</em> 
    </h1>

    <?php
    $noresults=true;
    $query=$_GET["search"];
    $sql="SELECT * FROM `threads` WHERE match (thread_title,thread_desc) against ('$query')";
    $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){
            $noresults=false;
            $title=$row['thread_title'];
            $desc=$row['thread_desc'];
            $thread_id=$row['thread_id'];
            $url="threads.php?thread_id=".$thread_id;

            echo '
                <div class="result">
                    <h3><a id="me" href="'.$url.'" class="text-dark">'.$title.'</a></h3>
                    <p>'.$desc.' </p>
                </div>';
        }
        if($noresults){
            echo '<div class="container my-4" >
                    <div class="jumbotron ">
                        <h1 class="display-4 "> <b>No Results found</b></h1>
                        <p class="lead"><?php echo $desc ?></p>
                        <hr class="my-4">
                        <p><i>Suggestions:
                        <ul>
                        <li>Make sure that all words are spelled correctly.</li>
                        <li>Try different keywords.</li>
                        <li>Try more general keywords.</li>
                        <li>Try fewer keywords.</li>
                        </ul>
                        </i></p>
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