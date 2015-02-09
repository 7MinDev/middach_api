<?php

/**
 * @author pschmidt
 */

class RestaurantControllerTest extends AuthTestCase
{
	/**
	 * @test
	 */
	public function should_respond_with_a_http_ok()
	{
		$data = [
			'name' => 'Test Restaurant 1',
			'street' => 'Test-street 1',
			'town' => 'Test town',
			'postal_code' => '12345',
			'description' => 'Some description',
			'feedback_email' => 'feedback@test.de',
			'website' => 'www.google.de'
		];

		$response = $this->call('POST', route('restaurants.create', $data));
		$this->assertTrue($response->isOk(), $response->getContent());
	}
}