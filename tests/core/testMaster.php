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
        require_once preg_replace("/(?:tests\/)([a-z]+)\/([a-zA-Z0-9-_]*).php/", "src/$1/".str_replace("_", "/", $class).".php", $_SERVER['SCRIPT_FILENAME']);
    }
}