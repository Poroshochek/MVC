<?php

class JaksonEngine
{
    public
        $settings, // settings
        $uri, // current URI
        $app; // current APP

    public function __construct($settings)
    {
        $this->settings = $settings;
        $this->uri = urldecode(preg_replace('/\?.*/iu','',$_SERVER['REQUEST_URI']));
        $this->app = false;
        $this->processPath();
        $this->processControllers();
    }

    public function processPath()
    {
        foreach ($this->settings['apps'] as $iterableApp) {
            $iterableUrls = require(BASE_DIR . '/apps/' . $iterableApp . '/urls.php');
            foreach ($iterableUrls as $pattern => $method) {
                $matches = array();
                if(preg_match($pattern, $this->uri, $matches)) {
                    $this->app = array($iterableApp, array('pattern' => $pattern,
                                                            'method' => $method,
                                                            'args'   => $matches));
                    break(2);
                }
            }
        }

        if ($this->app === 'false') {
            exit('App not found');
        }
    }

    public function processControllers()
    {
        if ($this->app || is_array($this->app)) {
            require(BASE_DIR . '/apps/' . $this->app['0'] . '/controller.php');
            $controllerName = $this->app['0'] . 'Controller';
            $this->appController = new $controllerName();
            $this->appController->{$this->app['1']['method']}($this->app['1']['args']);
        }
    }

}