<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss-Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <style>
    .container {
        min-height: 81vh;
    }
    </style>
</head>

<body>

    <?php
    include 'partials/conn.php';
    include 'partials/header.php';
    ?>

    <div class="container my-3">
        <h1>Search Results for <em>"<?php echo $_GET['search']; ?>"<em></h1>

        <?php

            $noResult=true;
            $query=$_GET["search"];
            $sql="select * from `threads` where match(thread_title,thread_desc) against('$query')";
            $result=mysqli_query($conn,$sql);

            while($row=mysqli_fetch_assoc($result))
            {
                $title=$row['thread_title'];
                $desc=$row['thread_desc'];
                $thread_id=$row['threads_id'];

                $url="threads.php?threadid=".$thread_id;
                $noResult=false;
                
                echo'
                <div>
                <h3><a href="'.$url.'" class="text-dark">'.$title.'</a></h3>
                <p>'.$desc.'</p>
                </div>';
            }
            
            if($noResult)
            {
                echo '<div class="alert alert-dark my-4" role="alert">
                            <p class="alert-heading"><b>Your search "'.$query.'" did not match any threads.</b></p>
                            <hr>
                            <p class="mb-0 text-center">
                                <ul>Suggestions:
                                    <li>Make sure that all words are spelled correctly.</li>
                                    <li>Try different keywords.</li>
                                    <li>Try more general keywords.</li>
                                </ul>
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