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
    private $ctable = array ();

    /**
     * An array of scripts the application will call at specific times.
     * @var array scripts
     * @access private
     */
    private $scripts = array ();

    /**
     * An array containing paramenters parsed from the clean url.
     * @var array  params;
     * @access private
     */
    private $params = array ();

    /**
     * Constructs the Application object and loads the classloader.
     * @todo error handling
     * @param string $path_to_class_loader
     */
    public function __construct($path_to_class_loader)
    {
        require_once $path_to_class_loader;

    }

    /**
     * Determines if a passed script is runnable.
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
     * Sets the path to a script run before business logic starts.
     * @param string $path
     * @return boolean
     */
    public function setRuntimeScript($path)
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
     * Returns an array containing parameters created from the current uri
     * @return array
     */
    public function getParams()
    {

        if (!count($this->params) > 0)
        {

            $url = urldecode($_SERVER['REQUEST_URI']);

            @$params = explode('/', $url);

            array_shift($params);

            if (empty($params[0]))
                array_shift($params);

            $this->params = $params;
        }

        return $this->params;

    }

    /**
     * Starts execution of the script.
     * @return void
     */
    public function run()
    {

        //This script should initialize the environment settings files and the ctables.
        if ($this->scripts['boot'])
            include_once "{$this->scripts['boot']}";

        $this->params = new Parameters();

        $this->cfactory = new ControllerFactory();

        $args = $this->params->getParams();

        $controller = $this->cfactory->getController($this, $args);

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
