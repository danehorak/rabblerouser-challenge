<?php

use App\Models\LatLong;

class LatLongTest extends TestCase {

	/**
	 * Setup the test environment.
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
	}

	/**
	 * LocationController::store
	 *
	 * @return void
	 */
	public function testGetMethod()
	{
		// Set Input
		$input = '1600 29th St, Boulder, CO 80301';

		// Instantiate LatLong
		$obj = new LatLong();
		$obj->setAddress($input);

		// Get Address Coordinates
		$latlong = $obj->get();

		// Should return lat 40.027291 long -105.255931
		$this->assertEquals(40.027291, $latlong['lat']);
		$this->assertEquals(-105.255931, $latlong['long']);

		//----------------------------------------------------

		// Set Bad Address
		$obj->setAddress('Bad Address Format');

		// Get Address Coordinates
		$latlong = $obj->get();

		// Should return lat 0 long 0
		$this->assertEquals(0, $latlong['lat']);
		$this->assertEquals(0, $latlong['long']);
	}

	/**
	 * Clean up the testing environment before the next test.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		parent::tearDown();
	}

}
