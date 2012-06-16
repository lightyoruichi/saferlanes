<?php

/**
 * timestamp May 2, 2012 4:42:48 AM
 *
 *
 * @author Lasana Murray  <lmurray@trinistorm.org>
 * @copyright 2012 Lasana Murray
 * @package callow\mvc
 *
 *  The application class is responsible for setting up the environment and
 *   running a controller for the requested action.
 *
 */

namespace callow\mvc;


final class Application
{

    /**
     * Stores the internal ControllerFactory
     * @var ControllerFactory $cfactory
     * @access private
     */
    private $cfactory;


    /**
     * The ctable is an array mapping keywords to application controllers.
     * @var array $ctable;
     * @access private
     */
    private $ctable = array();

    /**
     * An array of scripts the application will call at specific times.
     * @var array scripts
     * @access private
     */
    private $scripts = array ();

    /**
     * Internal object that treats the current url as a collection of parameters.
     * @var callow\mvc\Parameters  params;
     * @access private
     */
    private $params;


    public function __construct($path_to_class_loader = NULL)
    {
        if($path_to_class_loader)
            require_once $path_to_class_loader;
    }

    /**
     *
     * @param string $path
     * @param string $order
     * @return boolean
     */
    private function _isRunnable($path, $order)
    {


        if (is_string($path))
        {

            $fullpath = str_replace('.:', NULL, get_include_path() . "/" . $path);

            if (file_exists($path))
            {

                $this->scripts[$order] = $path;

                return TRUE;
            }
            elseif (file_exists($fullpath))
            {
                $this->scripts[$order] = $fullpath;
            }
        }
        else
        {
            return FALSE;
        }

    }

    /**
     * Sets the path to a script that conditions the environment for the script
     * @param string $path
     * @return boolean
     */
    public function setBootScript($path)
    {

        return $this->_isRunnable($path, 'boot');

    }

    /**
     * Sets the path to a script that bootstraps the application.
     * @param string $path
     * @return boolean
     */
    public function setStartUpScript($path)
    {

        return $this->_isRunnable($path, 'startup');

    }

    /**
     * Sets the path to a script that will be run before the application terminates.
     * @param string $path
     * @return boolean
     */
    public function setFinishScript($path)
    {

        return $this->_isRunnable($path, 'finish');

    }

    /**
     * Assigns the ctable that will be used by the controller factory.
     * @param array $ctable
     * @return void
     */
    public function useTable(array $ctable)
    {
        $this->ctable = $ctable;
    }

    /**
     * Starts execution of the script.
     * @return void
     */
    public function run()
    {

        //This script should get the class loader going and load the ctables.
        if ($this->scripts['boot'])
            include_once "{$this->scripts['boot']}";

        $this->params = new Parameters();

        $this->cfactory = new ControllerFactory();

        $args = $this->params->getParams();

        $controller = $this->cfactory->getController($args);

        //This script should declare any application specific constants and other settings.
        if ($this->scripts['startup'])
            include_once "{$this->scripts['startup']}";

        $controller->main();

        //This script is here to preform reporting, garbage collection, logging etc.
        if ($this->scripts['finish'])
            include_once "{$this->scripts['finish']}";

    }

}

?>
