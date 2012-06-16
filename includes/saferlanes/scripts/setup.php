<?php

// @date May 26, 2012 11:07:07 PM
// @author Lasana Murray  <lmurray@trinistorm.org>
// @project roadtroll
// Copyright (C) 2012 Lasana Murray



$controllers->setControllerTable($table);
$controllers->setIndex('saferlanes\controllers\SearchController');
$controllers->setDefaultController('saferlanes\controllers\DisplayController');

if(count($params) > 4)
    header('Location:/');

require_once 'settings.php';

require_once 'dbcreds.php';


?>
