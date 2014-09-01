<?php
define("BASE_TEST", (file_exists("C:/wamp/www/market3w-test/tests/core/indexReplace.php"))?"C:/wamp/www/market3w-test/tests/":"/var/lib/jenkins/jobs/market3w-test/workspace/tests/");
define("BASE_SRC", str_replace("tests", "src", BASE_TEST));
define("FOLDER","api");

require_once BASE_TEST."core/indexReplace.php";

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
