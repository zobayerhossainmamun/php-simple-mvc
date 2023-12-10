<?php

class Bootstrap {

    protected $_url;
    private $_controller = NULL;
    private $_defaultController;

    public function __construct(){
        $this->_getUrl();
    }
    public function setController($name){
        $this->_defaultController = $name; 
    }

    public function init(){
        if(empty($this->_url[0])){
            $this->_loadDefaultController();
            return false;
        }
        $this->_loadExistingController();
        $this->_callControllerMethod();
    }

    protected function _getUrl(){
        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : NULL;
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/',$url);
    }

    protected function _loadDefaultController(){
        require DOCROOT.'/controller/'.$this->_defaultController.'.php';
        $this->_controller = new $this->_defaultController();
        $this->_controller->index();
    }

    protected function _loadExistingController(){

        //set url for controllers
        $file = DOCROOT.'/controller/'.$this->_url[0].'.php';

        if(file_exists($file)){
            require $file;

            //instatiate controller
            $this->_controller = new $this->_url[0];


        } else {
            return false;
        }

    }
    protected function _callControllerMethod()
    {
        $length = count($this->_url);
        
        // Make sure the method we are calling exists
        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_url[1])) {
                // Goto Error
                return false;
            }
        }

        
        // Determine what to load
        switch ($length) {
            case 5:
                //Controller->Method(Param1, Param2, Param3)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;
            
            case 4:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;
            
            case 3:
                //Controller->Method(Param1)
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;
            
            case 2:
                //Controller->Method()
                $this->_controller->{$this->_url[1]}();
                break;
            
            default:
                $this->_controller->index();
                break;
        }
    }
}
