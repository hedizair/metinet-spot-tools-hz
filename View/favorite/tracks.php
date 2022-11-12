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





<main>

    <nav class="navbar navbar-expand-lg navbar-light mb-3 bg-light border border-white-50">


        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/favorite">Albums</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/favorite/tracks">Tracks</a>
                </li>

            </ul>
        </div>
    </nav>

    <div class="album px-2 py-5 bg-light border border-white-50">

        <div class="container">


            <div class="row">

                <table class="table table-success table-striped table-hover ">
                    <tr>
                        <th>Titre</th>
                        <th>Durée</th>
                        <th>Numero de track</th>
                        <th>ID</th>
                        <th>Favoris</th>
                    </tr>

                    <?php

                    foreach ($TAB_TRACKS_ALL as $item){
                        echo
                            '
                                <tr>
                                    <td>'.$item->getName() .'</td>
                                    <td>'.$item->getDuration() .'</td>
                                    <td>'.$item->getTrackNumber() .'</td>
                                    <td>'.$item->getIdSpotify() .'</td>
                                    <td><a href="/favorite/deleteFavoriteTrack/'.$item->getIdSpotify().'" class="btn btn-sm btn-outline-secondary" role="button">delete fav</a></td>
                                </tr>
                            ';
                    }

                    ?>



                </table>


            </div>
        </div>
    </div>


</main>




<footer class="py-3  gradient-blue-lol border-top mt-5">



</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous"></script>


</body>


</html>

