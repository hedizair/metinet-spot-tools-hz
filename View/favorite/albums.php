<?php


use App\Autoloader;
use App\Entity\Artist;

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#7952b3">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>Album</title>



</head>


<body>







<main>

    <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light mb-3 bg-light border border-white-50">


        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/favorite">Artists</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/favorite/tracks">Tracks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/favorite/albums">Albums</a>
                </li>

            </ul>
        </div>
    </nav>




    <form class="mb-3" method="post" action="../favorite/albums">
        <div class="container d-flex flex-row">


            <div class="col-3">
                <label for="select-query" class="form-label">Choisir un album</label>
                <select name="select-query" class="form-select mb-3" aria-label="Default select example">
                    <option value="" selected disabled>-- Choisir un album --</option>
                    <option value="all">Tous</option>
                    <?php
                    foreach($TAB_ALBUMS_ALL as $item){
                        echo '<option value="'. $item->getIdSpotify().'"> '.$item->getName() .'</option>';
                    }
                    ?>


                </select>
            </div>



        </div>
        <div class="container ml-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <div class="album py-5 px-2 bg-light border border-white-50">

        <div class="row">

            <?php

            foreach($TAB_RESULTS as $item){

                $link = str_replace("https://api.spotify.com/v1/albums/","https://open.spotify.com/album/",$item->getLink());

                echo '
                     <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <div class="card-body">
                                <img class="card-img-top" src=" '. $item->getPicture() .' "  data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" data-holder-rendered="true">
                                <h3> '. $item->getName() . '</h3>
                                <ul>
                                    <li>Total de tracks : '.$item->getTotaltracks() .'.</li>
                                    <li>Date de release : '.$item->getReleaseDate() .'.</li>
                                
                                </ul>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="http://localhost:8001/search/tracks/'.$item->getIdSpotify() .'" class="btn btn-sm btn-outline-secondary" role="button">Details</a>
                                        <a href="'.$link.'" class="btn btn-sm btn-outline-secondary" role="button" target="_blank">Spotify-redirect</a>
                                        <a href="/favorite/deleteFavoriteAlbum/'.$item->getIdSpotify() .'" class="btn btn-sm btn-outline-secondary" role="button"><img width="22px"  class="img-fluid" src="/croix.png"></a>
                                     </div>
                                     <small class="text-muted">'.$item->getTotalTracks() .' tracks</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
            }

            ?>


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


<!--  -->

