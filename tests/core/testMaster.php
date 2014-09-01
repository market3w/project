<?php
class TestMaster extends PHPUnit_Framework_TestCase {
    public function __construct() {        
        spl_autoload_register(array($this,'class_autoload'));
    }
    
    protected function setUp() {
    }
    
    protected function tearDown() {
    }
    
    public function class_autoload($class){
        require_once BASE_SRC.FOLDER."/".str_replace("_", "/", $class).".php";
    }
}