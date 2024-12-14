<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss-Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      .height {
        min-height:74vh;
      }
    </style>
  </head>
  <body>
  
    <?php
    include 'partials/conn.php';
    include 'partials/header.php';
    ?>

    <div class="container my-4 height">
      <h3 class="my-4"><b>
      Welcome to iDiscuss, a vibrant community dedicated to all things coding and programming. Whether you're a developer, a curious student, or someone just starting out in the world of coding, iDiscuss is your go-to place for insightful discussions, problem-solving, and learning from peers.
      </b></h3>
      <hr>
      <h4 class="my-4">
      <b><u>Our Mission</u></b>
      is to create an inclusive platform where knowledge meets passion. We aim to empower individuals by fostering a supportive environment where everyone can share their expertise, ask questions without hesitation, and grow together as a community.
      </h4>
    </div>
    
    <?php
    include 'partials/footer.php';
    ?>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
