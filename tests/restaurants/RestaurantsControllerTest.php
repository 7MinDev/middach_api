<?php

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
	public function should_create_a_restaurant_and_return_it()
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
		$this->assertTrue($response->isOk(), 'Response code should be 200. Got ' . $response->getStatusCode() . 'instead.' . $response->getContent());

		$json = json_decode($response->getContent());

		$userId = Sentinel::getUser()->getUserId();

		$this->assertEquals($userId, $json->data->user_id);
		$this->assertEquals($data['name'], $json->data->name);
	}
}
