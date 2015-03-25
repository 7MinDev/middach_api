<?php
/**
 * @author pschmidt
 */
class OpeningTimesControllerTest extends AuthTestCase
{

	/**
	 * @test
	 */
	public function this_should_create_a_opening_time_for_the_given_restaurant()
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
}
