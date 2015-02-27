<?php

class DocumentationControllerTest extends TestCase {

	/**
	 * Documentation returns status 200
	 *
	 * @return void
	 */
	public function testDocumentationReturnsStatusTwoHundred()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(200, $response->getStatusCode());
	}

}
