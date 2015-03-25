<?php

use App\Models\OpeningTime;

/**
 * @author pschmidt
 */
class OpeningTimesRepositoryTest extends TestCase
{
	/**
	 * @var \App\Repositories\OpeningTimeRepository
	 */
	private $repository;

	/**
	 *
	 */
	public function setUp()
	{
		parent::setUp();
		$this->repository = App::make('App\Repositories\OpeningTimeRepository');
	}

	/**
	 *
	 * @test
	 */
	public function should_update_the_time_of_a_opening_time_entry()
	{
		$data = [
			'opening_time' => '09:00:00',
		];

		$openingTime = $this->repository->update(1, $data);

		$this->assertTrue($openingTime instanceof OpeningTime);
		$this->assertEquals($data['opening_time'], $openingTime->opening_time, 'Opening Times do not match.');
	}

	/**
	 *
	 * @test
	 */
	public function should_delete_a_opening_time()
	{
		$this->repository->delete(1);

		$openingTime = $this->repository->findById(1);

		$this->assertEmpty($openingTime, 'Opening Time was not deleted.');
	}
}
