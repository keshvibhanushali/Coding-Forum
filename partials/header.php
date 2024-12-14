<?php
session_start();
echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/coding-forum">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/coding-forum">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Top Categories
          </a>
          <ul class="dropdown-menu">';

            $sql="select  category_name, category_id from `categories` limit 5";
            $result=mysqli_query($conn,$sql);
             
            while($row=mysqli_fetch_assoc($result)){
            echo'
            <li><a class="dropdown-item" href="threadlist.php?cat_id='.$row['category_id'].'">'.$row["category_name"].'</a></li>';
            }
            
            echo '
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>
      <div class="d-flex align-items-center">';

      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true")
      {
      echo'
        <form class="d-flex me-2" role="search" method="GET" action="search.php">
          <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
          <p class="text-light my-0 mx-2">Welcome '.$_SESSION['useremail'].'</p>
          <a href="partials/logout.php" class="btn btn-outline-success pt-2">Logout</a>
        </form>';
      }
      else
      {
      echo '
        <button class="btn btn-outline-success me-2"  data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-outline-success"  data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</button>
        ';
      }
     echo ' 
     </div>
    </div>
  </div>
</nav>';


include 'partials/loginModal.php';
include 'partials/signupModal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true")
{
  echo 
   '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
     <strong>Success!</strong> Your account has been created you can login now.
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
else if(isset($_GET['error']) && $_GET['error']!="false")
{
  echo 
   '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
     <strong>Error!</strong>'.$_GET['error'].
     '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
?>