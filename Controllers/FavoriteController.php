<?php

namespace App\Controllers;

use App\Entity\Artist;
use App\Entity\Model;
use App\Entity\Track;

class FavoriteController extends Controller
{
    public function index(){
        $artists = new Artist('','',0,[''],'','');
        $TAB_ARTISTS_ALL = [];
        $TAB_RESULTS = [];
        $result = [];
        $resultById = [];

        $result = $artists->findAll();
        foreach ($result as $artist){
            array_push($TAB_ARTISTS_ALL, new Artist(
                    $artist->idSpotify, $artist->name,$artist->followers,json_decode($artist->genders),$artist->link,$artist->picture)
            );
        }

        if(isset($_POST['select-query']) && $_POST['select-query'] !== "" && $_POST['select-query'] !== 'all'){
            echo $_POST['select-query'] ;
            $resultById = $artists->findBy(array('idSpotify' => $_POST['select-query']));
            array_push($TAB_RESULTS, new Artist(
                    $resultById[0]->idSpotify, $resultById[0]->name,$resultById[0]->followers,json_decode($resultById[0]->genders),$resultById[0]->link,$resultById[0]->picture)
            );


        }else{

            $TAB_RESULTS = $TAB_ARTISTS_ALL;
        }




        $this->render('/favorite/index',compact("TAB_RESULTS","TAB_ARTISTS_ALL"));


    }

    public function tracks(){
        $track = new Track('','',0,0,'');

        $result = $track->findAll();
        foreach ($result as $track){
            $TAB_TRACKS_ALL[] = new Track($track->idSpotify, $track->name, $track->duration, $track->trackNumber, $track->link);
        }


        $this->render('/favorite/tracks',compact("TAB_TRACKS_ALL"));


    }

    function addFavoriteArtist($id,$name){

        if($this->isFavoriteExist('artist',$id)){
            echo 'Deja en favoris';
            header("Location : /search");
            exit();
        }




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


    function deleteFavoriteArtist($idSpotify){
        if(!$this->isFavoriteExist('artist',$idSpotify)){
            echo "l'artiste n'existe pas en favorie";
            header("Location : /search");
            exit();
        }
        $artist = new Artist('','',0,[''],'','');
        $a = $artist->findBy(array('idSpotify' => $idSpotify));
        $artist->delete($a[0]->id);

    }

    function addFavoriteTrack($idSpotify){


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/tracks/".$idSpotify);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result);



        $t = $jsonResult;

        if($this->isFavoriteExist('track',$t->id)){
            echo 'Deja en favoris';
            header("Location : /search");
            exit();
        }

        $track = new Track($t->id,$t->name,$t->duration_ms,$t->track_number,$t->href);

        $track->create();
        header("Location : /search");
        exit();
    }

    function deleteFavoriteTrack($idSpotify){
        if(!$this->isFavoriteExist('track',$idSpotify)){
            echo "la track n'existe pas en favorie";
            header("Location:/search");
            exit();
        }
        $track = new Track('','',0,0,'');
        $t = $track->findBy(array('idSpotify' => $idSpotify));
        $track->delete($t[0]->id);

    }


    function isFavoriteExist($model, $dataSpotifyId){
        $m = '';
        if($model === 'artist'){
            $m = new Artist('','',0,[''],'','');
        }elseif($model === 'track'){
            $m = new Track('','',0,0,'');
        }

        if(empty($m->findBy(array('idSpotify' => $dataSpotifyId)))){
            return false;
        }else{
            return true;
        }
    }


}