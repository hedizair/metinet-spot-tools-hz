<?php

namespace App\Controllers;


use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Track;



class SearchController extends Controller
{

    public function index(){

        $TAB_ARTIST_GET = [];
        $TAB_ARTIST_FAVORITE = [];
        $currentQuery = '';

        if(isset( $_POST['search-query']) && $_POST['search-query'] !== ""){

            $searchQuery =  str_replace(' ','%20',$_POST['search-query']);
            $currentQuery = $searchQuery;
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q=".$searchQuery."&type=artist");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $jsonResult = json_decode($result);


            foreach ($jsonResult->artists->items as $key => $value){

                if(!isset($value->images[0]->url)){
                    $artist = new Artist($value->id,$value->name,$value->followers->total,$value->genres,$value->href,'no-image.png');
                }else{
                    $artist = new Artist($value->id,$value->name,$value->followers->total,$value->genres,$value->href,$value->images[0]->url);
                }

                array_push($TAB_ARTIST_GET,$artist);
                if($this->isFavoriteExist('artist',$artist->getIdSpotify()))
                    $TAB_ARTIST_FAVORITE[$artist->getIdSpotify()] = true;
                else
                    $TAB_ARTIST_FAVORITE[$artist->getIdSpotify()] = false;

            }

            curl_close($ch);
        }

        $this->render('/search/index',compact("TAB_ARTIST_GET","TAB_ARTIST_FAVORITE","currentQuery"));

    }

    public function albums($artistId){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/artists/$artistId/albums");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result);



        $TAB_ALBUM_GET = [];
        $TAB_ALBUMS_FAVORITES = [];
        foreach ($jsonResult->items as $value){

            if(!isset($value->images[0]->url)){
                $album = new Album($value->id,$value->name,$value->release_date,$value->total_tracks,$value->href,"no-image.png");
            }else{
                $album = new Album($value->id,$value->name,$value->release_date,$value->total_tracks,$value->href,$value->images[0]->url);
            }

            array_push($TAB_ALBUM_GET,$album);

            if($this->isFavoriteExist('album',$album->getIdSpotify()))
                $TAB_ALBUMS_FAVORITES[$album->getIdSpotify()] = true;
            else
                $TAB_ALBUMS_FAVORITES[$album->getIdSpotify()] = false;


        }

        curl_close($ch);

        $this->render('/search/albums',compact("TAB_ALBUM_GET","TAB_ALBUMS_FAVORITES"));
    }

    function tracks($albumId){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/albums/$albumId/tracks");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result);



        $TAB_TRACKS_GET = [];
        $TAB_TRACKS_FAVORITES = [];
        foreach ($jsonResult->items as $value){

            $track = new Track($value->id,$value->name,$value->duration_ms,$value->track_number,$value->href);
            array_push($TAB_TRACKS_GET,$track);

            if($this->isFavoriteExist('track',$track->getIdSpotify()))
                $TAB_TRACKS_FAVORITES[$track->getIdSpotify()] = true;
            else
                $TAB_TRACKS_FAVORITES[$track->getIdSpotify()] = false;

        }


        curl_close($ch);

        $this->render('/search/tracks',compact("TAB_TRACKS_GET","albumId","TAB_TRACKS_FAVORITES"));
    }

    function isFavoriteExist($model, $dataSpotifyId){
        $m = '';
        if($model === 'artist'){
            $m = new Artist('','',0,[''],'','');
        }elseif($model === 'track'){
            $m = new Track('','',0,0,'');
        }elseif($model === 'album'){
            $m = new Album('','','',0,'','');
        }


        if(empty($m->findBy(array('idSpotify' => $dataSpotifyId)))){
            return false;
        }else{
            return true;
        }
    }






}