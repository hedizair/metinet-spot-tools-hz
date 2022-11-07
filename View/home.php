<?php




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#7952b3">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>Tracks</title>



</head>


<body>




<header class="p-3 mb-3 border-bottom gradient-blue-lol">

</header>




<main>


    <div class="container">

        <form method="post" action="../search">
            <div class="mb-3">
                <label for="search-query" class="form-label">Rechercher un artist</label>
                <input type="text" class="form-control" id="search-query" name="search-query" aria-describedby="search-query-help">
                <div id="search-query-help" class="form-text">We'll never share your email with anyone else.</div>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

</main>


<footer class="py-3  gradient-blue-lol border-top mt-5">



</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous"></script>


</body>


</html>
