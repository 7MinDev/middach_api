<?php

/**
 * @author pschmidt
 */

class RestaurantControllerTest extends AuthTestCase
{
	/**
	 * @test
	 */
	public function should_return_a_http_ok()
	{
		$response = $this->call('GET', route('restaurants.find', [1]));

		$this->assertTrue($response->isOk(), $response->getContent());
	}
}