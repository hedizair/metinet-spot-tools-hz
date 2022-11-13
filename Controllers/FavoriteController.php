<?php

namespace App\Controllers;

use App\Entity\Album;
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
            //echo $_POST['select-query'] ;
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
        $tracks = new Track('','',0,0,'');

        $result = $tracks->findAll();
        foreach ($result as $track){
            $TAB_TRACKS_ALL[] = new Track($track->idSpotify, $track->name, $track->duration, $track->trackNumber, $track->link);
        }


        $this->render('/favorite/tracks',compact("TAB_TRACKS_ALL"));


    }

    public function albums(){
        $albums = new Album('','','',0,'','');
        $TAB_ALBUMS_ALL = [];
        $TAB_RESULTS = [];


        $result = $albums->findAll();

        foreach ($result as $album){
            array_push(
                $TAB_ALBUMS_ALL
                , new Album($album->idSpotify,$album->name,$album->releaseDate,$album->totalTracks,$album->link,$album->picture)
            );
        }

        if(isset($_POST['select-query']) && $_POST['select-query'] !== "" && $_POST['select-query'] !== 'all'){

            $resultById = $albums->findBy(array('idSpotify' => $_POST['select-query']));
            array_push($TAB_RESULTS, new Album(
                    $resultById[0]->idSpotify, $resultById[0]->name,$resultById[0]->releaseDate,$resultById[0]->totalTracks,$resultById[0]->link,$resultById[0]->picture,)
            );
        }else{

            $TAB_RESULTS = $TAB_ALBUMS_ALL;
        }


        $this->render('/favorite/albums',compact("TAB_RESULTS","TAB_ALBUMS_ALL"));
    }

    function addFavoriteArtist($id,$name){

        if($this->isFavoriteExist('artist',$id)){
            //echo 'Deja en favoris';
            header("Location:/search");
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
        header("Location:/search");
        exit();
    }


    function deleteFavoriteArtist($idSpotify){
        if(!$this->isFavoriteExist('artist',$idSpotify)){
            echo "l'artiste n'existe pas en favorie";
            header("Location:/search");
            exit();
        }
        $artist = new Artist('','',0,[''],'','');
        $a = $artist->findBy(array('idSpotify' => $idSpotify));
        $artist->delete($a[0]->id);
        header("Location:/search");
        exit();


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
            //echo 'Deja en favoris';
            header("Location:/search");
            exit();
        }

        $track = new Track($t->id,$t->name,$t->duration_ms,$t->track_number,$t->href);

        $track->create();
        header("Location:/search");
        exit();
    }

    function deleteFavoriteTrack($idSpotify){
        if(!$this->isFavoriteExist('track',$idSpotify)){
            //echo "la track n'existe pas en favorie";
            header("Location:/search");
            exit();
        }
        $track = new Track('','',0,0,'');
        $t = $track->findBy(array('idSpotify' => $idSpotify));
        $track->delete($t[0]->id);
        header("Location:/search");
        exit();

    }

    function addFavoriteAlbum($idSpotify){


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/albums/".$idSpotify);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $_SESSION['token'] ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $jsonResult = json_decode($result);

        $a = $jsonResult;

        if($this->isFavoriteExist('album',$a->id)){
            //echo 'Deja en favoris';
            header("Location:/search");
            exit();
        }

        if(!isset($a->images[0]->url)){
            $album  = new Album($a->id,$a->name,$a->release_date,$a->total_tracks,$a->href,"NO");
        }else{
            $album = new Album($a->id,$a->name,$a->release_date,$a->total_tracks,$a->href,$a->images[0]->url);
        }

        $album->create();
        header("Location:/search");
        exit();
    }

    function deleteFavoriteAlbum($idSpotify){
        if(!$this->isFavoriteExist('album',$idSpotify)){
            //echo "l'album n'existe pas en favoris";
            header("Location:/search");
            exit();
        }
        $album = new Album('','','',0,'','');
        $a = $album->findBy(array('idSpotify' => $idSpotify));
        $album->delete($a[0]->id);

        header("Location:/search");
        exit();

    }




    function isFavoriteExist($model, $dataSpotifyId){
        $m = '';
        if($model === 'artist'){
            $m = new Artist('','',0,[''],'','');
        }elseif($model === 'track'){
            $m = new Track('','',0,0,'');
        }
        elseif($model === 'album'){
            $m = new Album('','','',0,'','');
        }

        if(empty($m->findBy(array('idSpotify' => $dataSpotifyId)))){
            return false;
        }else{
            return true;
        }
    }


}