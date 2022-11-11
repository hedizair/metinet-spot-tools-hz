<?php

namespace App\Controllers;

use App\Entity\Artist;
use App\Entity\Model;

class FavoriteController extends Controller
{
    public function index(){

        $this->render('favorite/index');

        $artists = new Artist('','',0,[''],'','');

        $TAB_ARTISTS = [];

        foreach ($artists as $artist){
            var_dump($artist);
            echo '<br>------<br>';
            //array_push($TAB_ARTISTS, )
        }

        var_dump($artists->findAll());
    }
}