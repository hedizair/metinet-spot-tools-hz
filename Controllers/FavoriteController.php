<?php

namespace App\Controllers;

use App\Entity\Artist;
use App\Entity\Model;

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
}