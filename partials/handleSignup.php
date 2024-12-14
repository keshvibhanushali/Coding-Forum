<?php
$showError="false";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    include 'conn.php';
    $email=$_POST['signupEmail'];
    $pass=$_POST['signupPassword'];
    $cpass=$_POST['cpassword'];

    //check wether username already exists
    $existsql="select * from `users` where user_email='$email'";
    $result=mysqli_query($conn,$existsql);
    $numRows=mysqli_num_rows($result);

    if($numRows>0)
    {
        $showError="Email already in use";
    }
    else 
    {
        if($pass==$cpass)
        {
            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $sql="insert into `users` (`user_email`,`user_pass`,`timestamp`) 
            values ('$email','$hash',current_timestamp())";
            $res=mysqli_query($conn,$sql);
            if($res)
            {
             $showAlert="true";
             header("Location:/coding-forum/index.php?signupsuccess=true");
             exit();
            }
        }
        else
        {
         $showError="Passwords do not match";
        }
    }
    header("Location:/coding-forum/index.php?signupsuccess=false&error=$showError");

}

?>