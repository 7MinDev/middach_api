<?php

/**
 * @author pschmidt
 */
class OpeningTimesControllerTest extends ControllerTestCase
{

	/**
	 * @test
	 */
	public function should_call_create_method_and_return_with_a_http_ok()
	{
		$data = [
			'restaurant_id' => 1,
			'day_of_week' => 7,
			'opening_time' => '09:00:00',
			'closing_time' => '15:00:00'
		];

		$mock = Mockery::mock('App\Repositories\Contracts\OpeningTimeRepositoryContract');
		$mock->shouldReceive('create')
			->once()
			->andReturn([
				'id' => 1,
				'restaurant_id' => 1,
				'opening_time' => '09:00:00',
				'closing_time' => '15:00:00'
			]);
		App::instance('App\Repositories\Contracts\OpeningTimeRepositoryContract', $mock);

		$response = $this->call('POST', route('restaurants.opening_time.create'), $data);
		$this->assertTrue($response->isOk(), $response->getContent());
	}

	/**
	 *
	 * @test
	 */
	public function should_call_update_method_and_return_with_a_http_ok()
	{
		$data = [
			'opening_time' => '08:00:00'
		];

		$mock = Mockery::mock('App\Repositories\Contracts\OpeningTimeRepositoryContract');
		$mock->shouldReceive('update')
			->once()
			->andReturn('foo');

		App::instance('OpeningTimeRepositoryContract', $mock);

		$response = $this->call('PUT', route('restaurants.opening_time.update', [1]), $data);

		$this->assertTrue($response->isOk(),
			'Response not OK. Got code ' . $response->getStatusCode() . ' instead.' . $response->getContent());
	}

	/**
	 *
	 * @test
	 */
	public function should_call_delete_method_and_return_with_a_http_ok()
	{
		$mock = Mockery::mock('App\Repositories\Contracts\OpeningTimeRepositoryContract');
		$mock->shouldReceive('delete')
			->once()
			->andReturn('foo');

		App::instance('OpeningTimeRepositoryContract', $mock);

		$response = $this->call('DELETE', route('restaurants.opening_time.delete', [1]));

		$this->assertTrue($response->isOk(),
			'Response not ok. Got code ' . $response->getStatusCode() . ' instead.');
	}
}
