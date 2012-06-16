<?php

/**
 *  Boot up script for saferlanes, loads the classloader and ctable.
 *
 */
function classloader_setup()
{
    spl_autoload_extensions('.php');
    spl_autoload_register(function ($package) {
                $php = '.php';

                $package = str_replace("\\", '/', $package) . $php;

                if (file_exists($package))
                {
                    require_once $package;
                    return;
                }
                else
                {
                    //check the include path
                    $package = str_replace('.:', NULL, get_include_path() . DIRECTORY_SEPARATOR . $package);
                    if (file_exists($package))
                    {
                        require_once $package;
                        return;
                    }
                }
            });

}

$this->ctable = array
        (

    /*Saferlanes secret keywords*/
    'post'=>'saferlanes\controllers\PostController',
    'vote'=>'saferlanes\controllers\VoteController',
    'about'=>'saferlanes\controllers\AboutPage',
    'contact'=>'saferlanes\controllers\ContactPage',
    'version'=>'saferlanes\controllers\Build'
    );

classloader_setup();


?>
