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

    <title>Album</title>



</head>


<body>




<header class="p-3 mb-3 border-bottom gradient-blue-lol">

</header>




<main>


    <div class="album py-5 bg-light">



        <div class="container">


            <div class="row">


                <?php

                foreach($TAB_ALBUM_GET as $item){
                    $link = str_replace("https://api.spotify.com/v1/artists/","https://open.spotify.com/artist/",$item->getLink());
                    echo
                        '
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
                                        <a href="http://localhost:8001/search/tracks/'.$item->getId() .'" class="btn btn-sm btn-outline-secondary" role="button">Details</a>
                                        <a href="'.$link.'" class="btn btn-sm btn-outline-secondary" role="button" target="_blank">Spotify-redirect</a>
                                       
                                    </div>
                                    <small class="text-muted">9 mins</small>
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
