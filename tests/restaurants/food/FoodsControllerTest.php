<?php
/**
 * @author pschmidt
 */
class FoodsControllerTest extends ControllerTestCase
{

	/**
	 *
	 * POST /restaurants/foods/create should call create method on the repository
	 * and return with a http ok.
	 *
	 * @test
	 */
	public function create_should_call_create_and_return_with_a_http_ok()
	{
		$data = [
			'title' => 'Schnitzel vom Schwein',
			'sub_title' => 'Pfefferrahmsoße / Jägersoße',
			'price' => 5.20,
			'additional_info' => 'Inhaltsstoffe blabla',
		];

		$response = $this->call('POST', route('restaurants.foods.create'), $data);

		$this->assertTrue($response->isOk(), 'Response was not ok. Got code '. $response->getStatusCode() . ' instead.');
	}

	/**
	 * @test
	 */
	public function update_should_call_update_and_return_with_a_http_ok()
	{
		$data = [
			'price' => 6.00
		];

		$response = $this->call('PUT', route('restaurants.foods.update', 1), $data);

		$this->assertTrue($response->isOk(), 'Response was not ok. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
	}
}
