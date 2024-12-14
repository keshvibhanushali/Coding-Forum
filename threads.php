<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss-Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body>

    <?php
    include 'partials/conn.php';
    include 'partials/header.php';
    ?>
    <?php
     $id = $_GET['threadid'];
     $sql = "SELECT * FROM `threads` WHERE threads_id=$id";
     $result=mysqli_query($conn,$sql);

       while($row=mysqli_fetch_assoc($result))
        {
            $title=$row['thread_title'];
            $desc=$row['thread_desc'];

            $thread_user_id=$row['thread_user_id'];
            
            //query the users tablr to find out the name of poster of the thread.
            $sql2="select user_email from `users` where sno='$thread_user_id'";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            $postedby=$row2['user_email'];
        }

    ?>

    <?php
    $showAlert=false;
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $comment=$_POST['comment'];

        $comment= str_replace("<","&lt;",$comment);
        $comment= str_replace(">","&gt;",$comment);

        $sno=$_POST['sno'];

        $sql="insert into `comments` (`comment_content`,`thread_id`,`comment_by`,`comment_time`)
        values ('$comment','$id','$sno',current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;

        if($showAlert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    ?>
    
    <div class="container my-4 minheight">
        <div class="alert alert-success" role="alert">
            <h2 class="alert-heading text-center"><?php echo $title;?></h2>
            <p><?php echo $desc;?></p>
            <hr>
            <p class="mb-0">This is peer to peer form for sharing knowledge with each other.
                This is a Civilized Place for Public Discussion. Please treat this discussion forum with the same
                respect you would a public park.
                Improve the Discussion.
            </p>
            <p class="my-3">Posted by:<b><?php echo $postedby; ?></b></p>
        </div>
    </div>

<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true")
{
echo'
    <div class="container">
        <h3>Post a Comment</h3>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">
            <div class="mb-3">
                <label for="comment" class="form-label">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success my-2">Post comment</button>
        </form>
    </div>';
}
else
{
  echo '<div class="container">
  <h3 class="text-center">Post a Comment</h3>
  <div class="alert alert-warning">
      <h4 class="text-center">Please login to post a comment</h4>
  </div>
  </div>';
}
?>

    <div class="container">
        <h3 class="text-center">Discussions</h3>
        <?php
        $id = $_GET['threadid'];
        $sql="select * from `comments` where thread_id=$id";
        $result=mysqli_query($conn,$sql);

        $noResult=true;

        while($row=mysqli_fetch_assoc($result))
        {
            $noResult=false;
            $comment_id=$row['comment_id'];
            $content=$row['comment_content'];
            $comment_time=$row['comment_time'];
            $thread_user_id=$row['comment_by'];

            $sql2="select user_email from `users` where sno='$thread_user_id'";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
        echo '
        <div class="row justify-content-center my-4">
            <div class="col-md-8 d-flex">
                <div class="flex-shrink-0">
                    <img src="images/userdefault.png" width="35px" alt="...">
                </div>
                <div class="flex-grow-1 ms-2">
                    '. $content.'<p class="my-0 text-end"><b> Commented by: '.$row2['user_email'].' at '.$comment_time.'</b></p>
                </div>
            </div>
        </div>';
    }
    if($noResult){
        echo '<div class="alert alert-dark" role="alert">
        <p class="alert-heading text-center"><b>No Comments Found</b></p>
        <hr>
        <p class="mb-0 text-center">Be the first person to comment
        </p>
    </div>';
    }
    ?>
    </div>

    <?php
    include 'partials/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>