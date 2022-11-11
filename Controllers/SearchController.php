<?php

namespace App\Controllers;

use App\Autoloader;
use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Track;


class SearchController extends Controller
{

    public function index(){

        $TAB_ARTIST_GET = [];

        if(isset( $_POST['search-query'])){

            $searchQuery =  str_replace(' ','',$_POST['search-query']);

            $ch = curl_init();


            curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q=".$searchQuery."&type=artist");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $jsonResult = json_decode($result);


            foreach ($jsonResult->artists->items as $key => $value){

                if(!isset($value->images[0]->url)){
                    $artist = new Artist($value->id,$value->name,$value->followers->total,$value->genres,$value->href,'NO');
                }else{
                    $artist = new Artist($value->id,$value->name,$value->followers->total,$value->genres,$value->href,$value->images[0]->url);
                }

                array_push($TAB_ARTIST_GET,$artist);

            }

            curl_close($ch);
        }






        $this->render('/search/index',compact("TAB_ARTIST_GET"));

    }

    public function albums($artistId){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/artists/$artistId/albums");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result);


        $TAB_ALBUM_GET = [];
        foreach ($jsonResult->items as $value){

            if(!isset($value->images[0]->url)){
                $album = new Album($value->id,$value->name,$value->release_date,$value->total_tracks,$value->href,"NO");
            }else{
                $album = new Album($value->id,$value->name,$value->release_date,$value->total_tracks,$value->href,$value->images[0]->url);
            }

            array_push($TAB_ALBUM_GET,$album);


        }

        curl_close($ch);

        $this->render('/search/albums',compact("TAB_ALBUM_GET"));
    }

    function tracks($albumId){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/albums/$albumId/tracks");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result);


        $TAB_TRACKS_GET = [];
        foreach ($jsonResult->items as $value){

            $track = new Track($value->id,$value->name,$value->duration_ms,$value->track_number,$value->href);
            array_push($TAB_TRACKS_GET,$track);

        }


        curl_close($ch);

        $this->render('/search/tracks',compact("TAB_TRACKS_GET"));
    }

    function favorite($id,$name){

        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/artists/$id");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result);

        if( isset($jsonResult->images[0]->url)){
            $artist = new Artist(
                $id,
                $name,
                $jsonResult->followers->total,
                $jsonResult->genres,
                $jsonResult->href,
                $jsonResult->images[0]->url);
        }else{
            $artist = new Artist(
                $id,
                $name,
                $jsonResult->followers,
                $jsonResult->genres,
                $jsonResult->href,
                'NO');
        }



        $artist->create();
        header("Location : /search");
        exit();
    }


}