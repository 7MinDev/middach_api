<?php
use App\Models\User;

/**
 * @author pschmidt
 */

class RestaurantControllerTest extends TestCase
{
	private $access_token = 'oj1zALA5emd42XmmzbJRMSmO8ClRBySPuzcHlvvA';

	/**
	 * @test
	 */
	public function should_respond_with_a_http_ok()
	{
		$user = User::find(1);
		Sentinel::setUser($user);

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

	public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
	{
		$server['HTTP_Authorization'] = 'Bearer ' . $this->access_token;

		return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
	}
}