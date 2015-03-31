<?php

/**
 * @author pschmidt
 */
class OpeningTimesControllerTest extends ControllerTestCase
{

	/**
	 * @test
	 */
	public function should_create_a_opening_time_for_the_given_restaurant()
	{
		$data = [
			'restaurant_id' => 1,
			'day_of_week' => 7,
			'opening_time' => '09:00:00',
			'closing_time' => '15:00:00'
		];

		$response = $this->call('POST', route('restaurants.opening_time.create'), $data);
		$this->assertTrue($response->isOk(), $response->getContent());
	}

	/**
	 *
	 * @test
	 */
	public function should_edit_a_opening_time()
	{
		$data = [
			'opening_time' => '08:00:00'
		];

		$response = $this->call('PUT', route('restaurants.opening_time.update', [1]), $data);

		$this->assertTrue($response->isOk(),
			'Response not OK. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
	}

	/**
	 *
	 * @test
	 */
	public function should_delete_a_opening_time()
	{
		$response = $this->call('DELETE', route('restaurants.opening_time.delete', [1]));

		$this->assertTrue($response->isOk(),
			'Response not ok. Got code ' . $response->getStatusCode() . ' instead.');
	}
}
