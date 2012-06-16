<?php

/**
 * timestamp May 5, 2012 9:00:02 PM
 *
 *
 * @author Lasana Murray  <lmurray@trinistorm.org>
 * @copyright 2012 Lasana Murray
 * @package callow\mvc
 *
 * Parent class for all controller classes.
 * In the callow package, controllers are responsible for the conditional
 * flow of the program. Models are the various classes of the program that
 * do actual work.
 *
 */

namespace callow\mvc;

abstract class Controller
{

    /**
     * Reference to the Global application object.
     * @var Application $env;
     */
    protected $env;


    public function __construct(Application $env)
    {

            $this->env = $env;
    }


    /**
     * The main method of the controller class.
     */
    abstract public function main ();


}

?>
