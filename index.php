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

    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/slider1.jpg" style="height:400px" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/slider2.avif" style="height:400px" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/slider3.webp" style="height:400px;" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- to submit the category form into database (category table) -->

    <?php
    $showAlert=false;
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $catname=$_POST['catname'];
        $catdesc=$_POST['catdesc'];

        $catname= str_replace("<","&lt;",$catname);
        $catname= str_replace(">","&gt;",$catname);

        $catdesc= str_replace("<","&lt;",$catdesc);
        $catdesc= str_replace(">","&gt;",$catdesc);

        $catname = mysqli_real_escape_string($conn, $_POST['catname']);
        $catdesc = mysqli_real_escape_string($conn, $_POST['catdesc']);

        //check wether category name already exists
        $existsql="select * from `categories` where category_name='$catname'";
        $result=mysqli_query($conn,$existsql);
        $numRows=mysqli_num_rows($result);

        if($numRows>0)
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            This category already exists. Browse following categories.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'; 
        }
        else 
        {
            $catname = mysqli_real_escape_string($conn, $_POST['catname']);
            $catdesc = mysqli_real_escape_string($conn, $_POST['catdesc']);    

            $sql="insert into `categories` (`category_name`,`category_description`,`created`)
            values ('$catname','$catdesc',current_timestamp())";
            $result=mysqli_query($conn,$sql);
            $showAlert="true";

               if($showAlert)
                {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> New category has been uploaded.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }
        }
    ?>

    <!-- to add new categories -->

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true")
      {
      echo'
    <div class="container my-3">
        <h3 class="text-center">Add a new category</h3>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
            <div class="mb-3">
                <label for="catname" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="catname" name="catname">
                <div id="emailHelp" class="form-text">
                  Check if the category already present then don\'t add a new one with the same name .
                </div>
            </div>
           
            <div class="mb-3">
                <label for="catdesc" class="form-label">Description about category</label>
                <textarea class="form-control" id="catdesc" name="catdesc" rows="3"></textarea>
            </div>
            <div id="emailHelp" class="form-text">
                Write something about the category.
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
    </div>';
      }
      else
      {
        echo '<div class="container my-3">
        <h3 class="text-center my-3">Add a new category</h3>
        <div class="alert alert-warning">
            <h4 class="text-center">Please login to add a new category</h4>
        </div>
        </div>';
      }
      ?>



    <div class="container my-3 minheight">
        <h2 class="text-center">iDiscuss- Browse Categories</h2>
        <div class="row">

        <?php
        $sql="select * from `categories`";
        $result=mysqli_query($conn,$sql);

        while($row=mysqli_fetch_assoc($result))
        {
          $id=$row['category_id'];
          $catname=$row['category_name'];
          $catdesc=$row['category_description'];

           echo '<div class="col-md-4">
                <div class="card my-2" style="width: 18rem;">
                    <img src="images/card'.$id.'.jpeg" class="card-img-top" alt="image for this category">
                    <div class="card-body">
                        <h5 class="card-title"><a href="threadlist.php?cat_id='.$id.' "> '.substr($catname,0,90).'</a></h5>
                        <p class="card-text"> '.substr($catdesc,0,90).'... </p>
                        <a href="threadlist.php?cat_id='.$id.'" class="btn btn-primary">View Threads</a>
                    </div>
                </div>
            </div>';
        }

        ?>

        </div>
    </div>


    <?php
    include 'partials/footer.php';

    if(isset($_GET['error']) && $_GET['error']=="false")
    {
      echo 
       '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
         <strong>Success!</strong> '.$_GET['error'].
         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>