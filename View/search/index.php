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


            <div class="d-flex justify-content-center mb-3">

                <form class="col-6" method="post" action="../search">
                    <div class="mb-3">
                        <label for="search-query" class="form-label">Rechercher un artiste</label>
                        <input type="text" class="form-control" id="search-query" name="search-query" aria-describedby="search-query-help">
                        <div id="search-query-help" class="form-text">Entrez le nom de l'artist pour afficher tous les résultats de votre recherche.</div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>

            </div>

            <div class="album py-5 px-2 bg-light border border-white-50">

                <?php
                if($currentQuery !== ''){
                    echo '<h4 class="mb-3">Liste des artistes résultant de la recherche : <em>'. $currentQuery .'</em></h4>' ;
                }else{
                    echo '<h4>Veuillez entrer une recherche</h4>';
                }

                ?>



                <div class="row">

                <?php

                foreach($TAB_ARTIST_GET as $item){
                    $genders = '';
                    $link = str_replace("https://api.spotify.com/v1/artists/","https://open.spotify.com/artist/",$item->getLink());
                    foreach( $item->getGenders() as $gender){
                        $genders .= ''.$gender.' , ';
                    }

                    echo
                    '
                     <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <div class="card-body">
                                <img class="card-img-top" src=" '. $item->getPicture() .' "  data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" data-holder-rendered="true">
                                <h3> '. $item->getName() . '</h3>
                                <p>
                                  Tags : '.$genders .'
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="/search/albums/'.$item->getIdSpotify() .'" class="btn btn-sm btn-outline-secondary" role="button">Details</a>
                                        <a href="'.$link.'" class="btn btn-sm btn-outline-secondary" role="button" target="_blank">Spotify redirect</a>';

                    if( $TAB_ARTIST_FAVORITE[$item->getIdSpotify()])
                        echo '<a href="/favorite/deleteFavoriteArtist/'.$item->getIdSpotify() .'" class="btn btn-sm btn-outline-secondary" role="button"><img width="22px"  class="img-fluid" src="croix.png"></a>';
                    else
                        echo '<a href="/favorite/addFavoriteArtist/'.$item->getIdSpotify() .'/'.$item->getName() .'" class="btn btn-sm btn-outline-secondary" role="button"><img width="22px"  class="img-fluid" src="plus.png"></a>';

                    echo '                     
                                    </div>
                                    
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

