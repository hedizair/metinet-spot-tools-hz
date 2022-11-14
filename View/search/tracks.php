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

    <div class="container">

        <div class="d-flex justify-content-center mb-3">

            <form class="col-6" method="post" action="/search">
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

        <div class="album py-5 bg-light border border-white-50 px-2">
            <h4 class="mb-3">Liste des tracks</h4>
                <table class="table table-success table-striped table-hover">
                    <tr>
                        <th>Titre</th>
                        <th>Durée</th>
                        <th>Numéro de track</th>
                        <th>ID</th>
                        <th>Spotify</th>
                        <th>Favorite</th>
                    </tr>

                    <?php

                        foreach ($TAB_TRACKS_GET as $item){
                            $link = str_replace("https://api.spotify.com/v1/tracks/","https://open.spotify.com/track/",$item->getLink());
                            echo
                            '
                                <tr>
                                    <td>'.$item->getName() .'</td>
                                    <td>'.$item->getDuration() .'</td>
                                    <td>'.$item->getTrackNumber() .'</td>
                                    <td>'.$item->getIdSpotify() .'</td>
                                    <td><a target="_blank" href="'. $link .'" /> spotify redirect</td>
                                    <td>';


                                if( $TAB_TRACKS_FAVORITES[$item->getIdSpotify()] )
                                    echo '<a href="/favorite/deleteFavoriteTrack/'.$item->getIdSpotify() .'" class="btn btn-sm btn-outline-secondary" role="button"><img width="22px"  class="img-fluid" src="/croix.png"></a>';
                                else
                                    echo '<a href="/favorite/addFavoriteTrack/'.$item->getIdSpotify() .'" class="btn btn-sm btn-outline-secondary" role="button"><img width="22px"  class="img-fluid" src="/plus.png"></a>';

                                echo '</td>
                                </tr>
                            ';
                        }

                    ?>



                </table>

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

