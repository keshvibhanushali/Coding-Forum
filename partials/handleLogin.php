<?php
$showError="false";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
  include 'conn.php';
  $email=$_POST['loginEmail'];
  $pass=$_POST['loginPassword'];
  $sql="select * from users where user_email='$email'";
  $result=mysqli_query($conn,$sql);
  $numRows=mysqli_num_rows($result);
  if($numRows>0)
  {
    $row=mysqli_fetch_assoc($result);
    if(password_verify($pass,$row['user_pass']))
    {
     session_start();
     $_SESSION['loggedin']=true;
     $_SESSION['sno']=$row['sno'];
     $_SESSION['useremail']=$email;

    //  echo "loggedin".$email;
    header("Location:/coding-forum/index.php");
   
    }
    else
    {
        // echo "unable to login";
        $showError="Oops! unable to login";
        header("Location:/coding-forum/index.php?error=$showError");
    }
  }
  else
  {
    $showError="Please enter correct email";
    header("Location:/coding-forum/index.php?error=$showError");
  }

}