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
        $this->assertEquals('',$res->serverErrorMessage);
    }
	
	/**
     * @covers Application_Controllers_Appointments::get_appointment
     * @todo   Implement testGet_appointment().
     */
    public function testGet_appointment() {
        $res = $this->object->get_allappointment(array("appointment_id"=>1));
        $this->assertFalse($res->apiError);
        $this->assertEquals('',$res->apiErrorMessage);
        $this->assertFalse($res->serverError);
        $this->assertEquals('',$res->serverErrorMessage);
    }
	
	/**
     * @covers Application_Controllers_Appointments::get_allappointmentcurrent
     * @todo   Implement testGet_allappointmentcurrent().
     */
    public function testGet_allappointmentcurrent() {
        $res = $this->object->get_allappointment(array());
        $this->assertFalse($res->apiError);
        $this->assertEquals('',$res->apiErrorMessage);
        $this->assertFalse($res->serverError);
        $this->assertEquals('',$res->serverErrorMessage);
    }
	
	/**
     * @covers Application_Controllers_Appointments::get_allappointmentuser
     * @todo   Implement testGet_allappointmentuser().
     */
    public function testGet_allappointmentuser() {
        $res = $this->object->get_allappointmentuser(array("user_id"=>1));
        $this->assertFalse($res->apiError);
        $this->assertEquals('',$res->apiErrorMessage);
        $this->assertFalse($res->serverError);
        $this->assertEquals('',$res->serverErrorMessage);
    }
	
	/**
     * @covers Application_Controllers_Appointments::post_appointment
     * @todo   Implement testPost_appointment().
     */
    public function testPost_appointment() {
        $res = $this->object->post_appointment(array("appointment_name"=>"test rdv", "appointment_description"=>"test rdv", "appointment_start_date"=>"2014-09-10", "appointment_start_hour"=>"10:00:00", "appointment_end_date"=>"2014-09-10", "appointment_end_hour"=>"12:00:00", "type_id"=>1));
        $this->assertFalse($res->apiError);
        $this->assertEquals('',$res->apiErrorMessage);
        $this->assertFalse($res->serverError);
        $this->assertEquals('',$res->serverErrorMessage);
    }
	
	/**
     * @covers Application_Controllers_Appointments::put_appointment
     * @todo   Implement testPut_appointment().
     */
    public function testPut_appointment() {
        $res = $this->object->put_appointment(array("appointment_id"=>1, "appointment_name"=>"test rdv", "appointment_description"=>"test rdv", "appointment_start_date"=>"10/09/14", "appointment_start_hour"=>"10:00:00", "appointment_end_date"=>"11/09/14", "appointment_end_hour"=>"12:00:00", "type_id"=>2));
        $this->assertFalse($res->apiError);
        $this->assertEquals('',$res->apiErrorMessage);
        $this->assertFalse($res->serverError);
        $this->assertEquals('',$res->serverErrorMessage);
    }
	
	/**
     * @covers Application_Controllers_Appointments::delete_appointment
     * @todo   Implement testDelete_appointment().
     */
    public function testDelete_appointment() {
        $res = $this->object->delete_appointment(array("appointment_id"=>1));
        $this->assertFalse($res->apiError);
        $this->assertEquals('',$res->apiErrorMessage);
        $this->assertFalse($res->serverError);
        $this->assertEquals('',$res->serverErrorMessage);
    }
}
