<?php

/**
 * Sets the controller table for saferlanes.
 */

if(count($this->params) > 4)
    header('Location:/');

$this->ctable = array
        (

    /*Saferlanes secret keywords*/
    'post'=>'saferlanes\controllers\PostController',
    'vote'=>'saferlanes\controllers\VoteController',
    );

$this->cfactory->setIndex('saferlanes\controllers\SearchController');
$this->cfactory->setDefaultController('saferlanes\controllers\DisplayController');





?>
