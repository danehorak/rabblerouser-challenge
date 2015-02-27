<?php

class LocationControllerTest extends TestCase {

	/**
	 * Setup the test environment.
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();

		Session::start();

		// Mock LatLong Object
		$LL = $this->getMockBuilder('App\Models\LatLong')
			->setMethods(['get'])
			->getMock();
		$LL ->method('get')
			->willReturn(['lat'=>'1', 'long'=>'1']);

		// Bind into App Container
		$this->app->instance('App\Models\LatLong', $LL);
	}

	/**
	 * LocationController::store
	 *
	 * @return void
	 */
	public function testCreateAction()
	{
		// Truncate Location Table
		\App\Models\Location::truncate();

		// Set Post Input
		$input = ['badPostField'=>'badPostField'];

		// Call Create Child Location Endpoint
		$response = $this->call('POST', 'api/v1/location', $input);

		// Should return status 400
		$this->assertEquals(400, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '{"error":"Expected POST parameters not found. Please see API documentation.","code":400}';
		$this->assertEquals($content, $response->getContent());

		//----------------------------------------------------

		// Set Post Input
		$input = ['address'=>'1600 29th St, Boulder, CO 80301'];

		// Call Create Endpoint
		$response = $this->call('POST', 'api/v1/location', $input);

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '{"address":"1600 29th St, Boulder, CO 80301","parent_id":0,"lat":"1","long":"1","id":1}';
		$this->assertEquals($content, $response->getContent());

		//----------------------------------------------------

		// Set Post Input
		$input = ['address'=>'1 Infinite Loop, Cupertino, CA 95014'];

		// Call Create Child Location Endpoint
		$response = $this->call('POST', 'api/v1/location/1/location', $input);

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '{"address":"1 Infinite Loop, Cupertino, CA 95014","parent_id":"1","lat":"1","long":"1","id":2}';
		$this->assertEquals($content, $response->getContent());

		//----------------------------------------------------

		// Mock LatLong Object
		$LL = $this->getMockBuilder('App\Models\LatLong')
			->setMethods(['get'])
			->getMock();
		$LL ->method('get')
			->willReturn(['lat'=>'0', 'long'=>'0']);

		// Bind into App Container
		$this->app->instance('App\Models\LatLong', $LL);

		// Set Post Input
		$input = ['address'=>'Some really malformed address'];

		// Call Create Child Location Endpoint
		$response = $this->call('POST', 'api/v1/location/1/location', $input);

		// Should return status 400
		$this->assertEquals(400, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '{"error":"Unable to accurately determine Latitude and Longitude. Please try adjusting the supplied Address.","code":400}';
		$this->assertEquals($content, $response->getContent());
	}

	/**
	 * LocationController::index
	 *
	 * @return void
	 */
	public function testGetResourceListAction()
	{
		$response = $this->call('GET', 'api/v1/location');

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '[{"id":1,"parent_id":0,"address":"1600 29th St, Boulder, CO 80301","lat":"1","long":"1"},{"id":2,"parent_id":1,"address":"1 Infinite Loop, Cupertino, CA 95014","lat":"1","long":"1"}]';
		$this->assertEquals($content, $response->getContent());

		//----------------------------------------------------

		// Set Post Input
		$input = ['address'=>'1601 29th St, Boulder, CO 80301'];

		// Call Create Child Location Endpoint
		$response = $this->call('POST', 'api/v1/location/2/location', $input);

		// Set Post Input
		$input = ['address'=>'1603 29th St, Boulder, CO 80301'];

		// Call Create Child Location Endpoint
		$response = $this->call('POST', 'api/v1/location/3/location', $input);

		// Set Post Input
		$input = ['address'=>'1605 29th St, Boulder, CO 80301'];

		// Call Create Child Location Endpoint
		$response = $this->call('POST', 'api/v1/location/1/location', $input);

		// Set Post Input
		$input = ['address'=>'1607 29th St, Boulder, CO 80301'];

		// Call Create Child Location Endpoint
		$response = $this->call('POST', 'api/v1/location/5/location', $input);

		// Set Post Input
		$input = ['address'=>'1609 29th St, Boulder, CO 80301'];

		// Call Create Child Location Endpoint
		$response = $this->call('POST', 'api/v1/location/6/location', $input);

		// Set Post Input
		$input = ['address'=>'1611 29th St, Boulder, CO 80301'];

		// Call Create Child Location Endpoint
		$response = $this->call('POST', 'api/v1/location', $input);

		//----------------------------------------------------

		$response = $this->call('GET', 'api/v1/location/7/location');

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '[]';
		$this->assertEquals($content, $response->getContent());

		//----------------------------------------------------

		$response = $this->call('GET', 'api/v1/location/2/location');

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '[{"id":3,"parent_id":2,"address":"1601 29th St, Boulder, CO 80301","lat":"1","long":"1"},{"id":4,"parent_id":3,"address":"1603 29th St, Boulder, CO 80301","lat":"1","long":"1"}]';
		$this->assertEquals($content, $response->getContent());
	}

	/**
	 * LocationController::show
	 *
	 * @return void
	 */
	public function testGetResourceAction()
	{
		$response = $this->call('GET', 'api/v1/location/1');

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '{"id":1,"parent_id":0,"address":"1600 29th St, Boulder, CO 80301","lat":"1","long":"1"}';
		$this->assertEquals($content, $response->getContent());
	}

	/**
	 * LocationController::update
	 *
	 * @return void
	 */
	public function testUpdateResourceAction()
	{
		$response = $this->call('PUT', 'api/v1/location/1', ['address'=>'2590 Pearl Street #110, Boulder, CO 80302']);

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '{"id":1,"parent_id":0,"address":"2590 Pearl Street #110, Boulder, CO 80302","lat":"1","long":"1"}';
		$this->assertEquals($content, $response->getContent());

		//----------------------------------------------------

		$response = $this->call('PUT', 'api/v1/location/1', ['badField'=>'badField']);

		// Should return status 400
		$this->assertEquals(400, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '{"error":"Expected POST parameters not found. Please see API documentation.","code":400}';
		$this->assertEquals($content, $response->getContent());
	}

	/**
	 * LocationController::ancestor
	 *
	 * @return void
	 */
	public function testAncestorAction()
	{

		$response = $this->call('GET', 'api/v1/location/4/7');

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '{"id":1,"parent_id":0,"address":"2590 Pearl Street #110, Boulder, CO 80302","lat":"1","long":"1"}';
		$this->assertEquals($content, $response->getContent());

		$response = $this->call('GET', 'api/v1/location/8/7');

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '[]';
		$this->assertEquals($content, $response->getContent());
	}

	/**
	 * LocationController::delete
	 *
	 * @return void
	 */
	public function testDeleteResourceAction()
	{
		$response = $this->call('DELETE', 'api/v1/location/1');

		// Should return status 200
		$this->assertEquals(200, $response->getStatusCode());

		// Assert Correct content is retuned
		$content = '';
		$this->assertEquals($content, $response->getContent());

		// Truncate Location Table
		\App\Models\Location::truncate();
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
