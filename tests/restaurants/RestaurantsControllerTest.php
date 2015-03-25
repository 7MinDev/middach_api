<?php
use App\Models\User;

/**
 * @author pschmidt
 */

class RestaurantsControllerTest extends AuthTestCase
{
	/**
	 * @test
	 */
	public function find_restaurant_should_return_a_http_ok()
	{
		$response = $this->call('GET', route('restaurants.find', [1]));

		$this->setIgnoreAuthorization(true);
		$this->assertTrue($response->isOk(), $response->getContent());
	}

	/**
	 * @test
	 */
	public function should_create_a_restaurant_and_return_the_right_user_id()
	{
		$data = [
			'name' => 'Günther Haack im Bankcarrée',
			'street' => 'Rudolf-Schwander-Straße 3',
			'town' => 'Kassel',
			'postal_code' => '34117',
			'description' => 'Günter Haack im bankcarreé. Impressum: Haack Catering, Inh. Günter Haack Meisterkoch, Rudolf-Schwander-Str. 3, 34117 Kassel, Tel. 0561-78931177',
			'website' => 'http://www.meisterkoch-haack.de/',
		];

		$response = $this->call('POST', route('restaurants.create'), $data);

		$this->assertTrue($response->isOk(),
			'Response code should be 200. Got ' . $response->getStatusCode() . ' instead.');

		$json = json_decode($response->getContent());

		$userId = Sentinel::getUser()->getUserId();

		$this->assertEquals($userId, $json->data->user_id);
	}

	/**
	 *
	 * @test
	 */
	public function should_update_a_restaurant()
	{
		$data = [
			'name' => 'Test test test',
			'postal_code' => 54321
		];

		$response = $this->call('PUT', route('restaurants.update', [1]), $data);

		$this->assertTrue($response->isOk(), 'Response not ok. Got code ' . $response->getStatusCode() . '.');
	}

	/**
	 *
	 * @test
	 */
	public function update_restaurant_of_another_user_should_result_in_an_error()
	{
		// TODO comment test in when we know how to disable middleware temporary
//		$user = User::find(2);
//		Sentinel::setUser($user);
//
//		$data = [
//			'name' => 'Voll das kack Restaurant',
//		];
//
//		// should fail because restaurant id 1 belongs to user id 1
//		$response = $this->call('PUT', route('restaurants.update', [1]), $data);
//
//		$this->assertTrue($response->isClientError(), 'Response was ok. Should have failed with a forbidden response');
	}

	/**
	 *
	 * @test
	 */
	public function should_delete_a_restaurant()
	{
		$response = $this->call('DELETE', route('restaurants.delete', [1]));

		$this->assertTrue($response->isOk(),
			'Response was not ok. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
	}
}
