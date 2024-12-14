<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss-Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
    .height {
        min-height: 76vh;
    }

    .width {
        width: 650px;
    }
    </style>
</head>

<body>

    <?php
    include 'partials/conn.php';
    include 'partials/header.php';
    ?>

    <?php
      if($_SERVER['REQUEST_METHOD']=="POST")
      {
        $contactemail=$_POST['contactemail'];
        $query=$_POST['query'];

        $sql="insert into `contactus` (`email`,`query`,`time`)
        VALUES ('$contactemail','$query',current_timestamp())";
        $result=mysqli_query($conn,$sql);

        if($result)
        {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> Your query has been submitted.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        else
        {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> Error ! Try again.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
      }
    ?>

    <div class="container my-3 height width">
        <h2 class="text-center">CONTACT US</h2>
        <h4 class="text-center">Feel free to contact us if you have any query or feedback</h4>

        <form action="<?php $_SERVER["REQUEST_URI"] ?>" method="POST">
            <div class="mb-3">
                <label for="contactemail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="contactemail" name="contactemail">
                <div id="emaildiv" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="query" class="form-label">List your query here:</label>
                <textarea class="form-control" id="query" name="query"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
     </div>

    <?php
    include 'partials/footer.php';
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>