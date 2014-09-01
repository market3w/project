<?php
die(var_dump($_SERVER['SCRIPT_FILENAME'],preg_replace("/(?:tests\/)([a-z]+)\/([a-zA-Z0-9-_]*).php/", "tests/core/indexReplace.php", $_SERVER['SCRIPT_FILENAME'])));
require_once preg_replace("/(?:tests\/)([a-z]+)\/([a-zA-Z0-9-_]*).php/", "tests/core/indexReplace.php", $_SERVER['SCRIPT_FILENAME']);

class AppointmentsTest extends TestMaster {

    /**
     * @var Appointments
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp() {
        $this->object = new Application_Controllers_Appointments;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Affiche::get_allappointment
     * @todo   Implement testGet_allappointment().
     */
    public function testGet_allappointment() {
        $res = $this->object->get_allappointment(array());
        $this->assertFalse($res->apiError);
        $this->assertNull($res->apiErrorMessage);
        $this->assertFalse($res->serverError);
        $this->assertNull($res->apiErrorMessage);
    }

}
