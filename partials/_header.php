<style>
#x{
  width:100%;
  padding:10px;
</style>
<?php
session_start();


echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/forum">Let\'s Discuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/forum/about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Top Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $sql="SELECT category_name,category_id FROM `categories` LIMIT 5";
        $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){
          echo '<li><a class="dropdown-item" href="threadlist.php?catid="'.$row['category_id'].'>'.$row['category_name'].'</a></li>';
          
        }
        echo '
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="/forum/contact.php" tabindex="-1" ="true">Contact </a>
      </li>
    </ul>
    <div class= " mx-2">';
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '<form class="d-flex" action="search.php" method="get">
      <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
          <p class="text-light my-0 mx-2" id="x">Welcome '. $_SESSION['username']. ' </p>
          <a role="button" href="partials/_logout.php" class="btn btn-outline-success ml-2">Logout</a>
          </form>';
    }
    else{ 
      echo '<form class="d-flex" action="search.php" method="get">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
      <button type="button" class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">
  Signup
</button>
      <button type="button" class="btn btn-outline-success mx-1" data-bs-toggle="modal" data-bs-target="#loginModal">
  Login
</button>
    </form>';

    }
    
  echo '</div>
    
  </div>
</div>
</nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

if(isset($_GET['signupSuccess'])&& $_GET['signupSuccess']=="true"){

  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> You Can Login!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['signupSuccess'])&& $_GET['signupSuccess']=="false"){
  
  echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
  <strong>Error!---></strong> '.$_GET['error'].'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
if(isset($_GET['loginSuccess'])&& $_GET['loginSuccess']=="true"){

  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Congrats!</strong> You are LoggedIn!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['loginSuccess'])&& $_GET['loginSuccess']=="false"){
  
  echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
  <strong>Sorry!Error---></strong> '.$_GET['error'].'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}



?>