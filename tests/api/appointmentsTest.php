<?php
/* extension du serveur  */
/* exemples :            */
/* "" pour .com          */
/* "prog" pour .prog.com */
define("EXT_SERVER","prog");

/* dossier à tester (api,intranet,siteweb,videoconference) */
define("FOLDER","api");

/* NE PAS CHANGER - AUTOMATIQUE */
$ext = (EXT_SERVER!="")? "-".EXT_SERVER : "";
define("BASE_TEST", (file_exists("C:/wamp/www/market3w".$ext."/tests/core/indexReplace.php"))?"C:/wamp/www/market3w".$ext."/tests/":"/var/lib/jenkins/jobs/market3w".$ext."/workspace/tests/");
define("BASE_SRC", str_replace("tests", "src", BASE_TEST));

require_once BASE_TEST."core/indexReplace.php";
/* ---------------------------- */

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
     * @covers Application_Controllers_Appointments::get_allappointment
     * @todo   Implement testGet_allappointment().
     */
    public function testGet_allappointment() {
        $res = $this->object->get_allappointment(array());
        $this->assertFalse($res->apiError);
        $this->assertEquals('',$res->apiErrorMessage);
        $this->assertFalse($res->serverError);
        $this->assertEquals('',$res->apiErrorMessage);
    }

}
