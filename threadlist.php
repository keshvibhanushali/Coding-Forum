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
    $id=$_GET['cat_id'];
    $sql="select * from `categories` where category_id=$id";
    $result=mysqli_query($conn,$sql);

        while($row=mysqli_fetch_assoc($result))
        {
            $catname=$row['category_name'];
            $catdesc=$row['category_description'];
        }
    ?>

    <?php
    $showAlert=false;
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $th_title=$_POST['title'];
        $th_desc=$_POST['desc'];

        $th_title= str_replace("<","&lt;",$th_title);
        $th_title= str_replace(">","&gt;",$th_title);

        $th_desc= str_replace("<","&lt;",$th_desc);
        $th_desc= str_replace(">","&gt;",$th_desc);

        $sno=$_POST['sno'];
        $sql="insert into `threads` (`thread_title`,`thread_desc`,`thread_cat_id`,`thread_user_id`,`timestamp`)
        values ('$th_title','$th_desc','$id','$sno',current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;

        if($showAlert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been uploaded.Wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    ?>

    <div class="container my-4 minheight">
        <div class="alert alert-success" role="alert">
            <h2 class="alert-heading text-center">Welcome to <?php echo $catname;?> Forums</h2>
            <p><?php echo $catdesc;?></p>
            <hr>
            <p class="mb-0">This is peer to peer form for sharing knowledge with each other.
                This is a Civilized Place for Public Discussion. Please treat this discussion forum with the same
                respect you would a public park.
                Improve the Discussion.
            </p>
            <button class="btn btn-success my-2">Learn More</button>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true")
      {
      echo'
    <div class="container">
        <h3 class="text-center">Start a discussion</h3>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Thread Title</label>
                <input type="text" class="form-control" id="title" name="title">
                <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible.</div>
            </div>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            <div class="mb-3">
                <label for="desc" class="form-label">Elaborate your problem</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
    </div>';
      }
      else
      {
        echo '<div class="container">
        <h3 class="text-center my-3">Start a discussion</h3>
        <div class="alert alert-warning">
            <h4 class="text-center">Please login to start a discussion</h4>
        </div>
        </div>';
      }
      ?>


    <div class="container">
        <h3 class="text-center">Browse Questions</h3>
        <?php
        $id=$_GET['cat_id'];
        $sql="select * from `threads` where thread_cat_id=$id";
        $result=mysqli_query($conn,$sql);

        $noResult=true;

        while($row=mysqli_fetch_assoc($result))
        {
            $noResult=false;
            $id=$row['threads_id'];
            $threadtitle=$row['thread_title'];
            $threaddesc=$row['thread_desc'];
            $time=$row['timestamp'];
            $thread_user_id=$row['thread_user_id'];

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
                    <h5 class="mt-0"> <a class="text-dark" href="threads.php?threadid='.$id.'"> '.$threadtitle.'</a></h5>
                    '. $threaddesc.' <p class="my-0 text-end"><b> Asked by: '.$row2['user_email'].' at '.$time.'</b></p>
                </div>
            </div>
        </div>';
    }

    // echo var_dump($noResult);
    if($noResult){
        echo '<div class="alert alert-dark" role="alert">
        <p class="alert-heading text-center"><b>No Threads Found</b></p>
        <hr>
        <p class="mb-0 text-center">Be the first person to ask a question
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