<?php

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * @author pschmidt
 */
class RestaurantsRepositoryTest extends TestCase
{
	/**
	 * @var \App\Repositories\RestaurantRepository
	 */
	private $repository;

	/**
	 * set up repository for our tests
	 */
	public function setUp()
	{
		parent::setUp();
		$this->repository = App::make('App\Repositories\RestaurantRepository');
	}

	/**
	 *
	 * @test
	 */
	public function should_find_a_restaurant_its_owner_and_opening_times()
	{
		$restaurant = $this->repository->findById(1);
		$this->assertTrue($restaurant instanceof Restaurant, 'return object was not an instance of Restaurant');

		$owner = $restaurant->owner;
		$this->assertTrue($owner instanceof User, 'owner was not an instance of User' . $owner);

		$openingTimes = $restaurant->openingTimes;
		$this->assertTrue($openingTimes instanceof Collection, 'opening times was not an instance of Collection');

		$this->assertEquals(1, $restaurant->id,
			'Expected $restaurant->id: 1 - actual: ' . $restaurant->id);
		$this->assertEquals('Test', $owner->first_name,
			'Expected $owner->first_name: Test - actual: ' . $owner->first_name);
	}

	/**
	 *
	 * @test
	 */
	public function should_create_a_new_restaurant()
	{
		$restaurant_data = [
			'user_id' => 1,
			'name' => 'Subway',
			'street' => 'Mauerstraße 11',
			'town' => 'Kassel',
			'postal_code' => '34117'
		];

		$restaurant = $this->repository->create($restaurant_data);

		$this->assertNotEmpty($restaurant, '$restaurant is empty');
		$this->assertTrue($restaurant instanceof Restaurant);
	}

	/**
	 *
	 * @test
	 */
	public function should_update_the_name_of_a_restaurant()
	{
		$data = [
			'name' => 'Super Test Restaurant'
		];

		$restaurant = $this->repository->update(1, $data);

		$this->assertTrue($restaurant instanceof Restaurant,
			'$restaurant is not an instance of Restaurant');

		$this->assertEquals($data['name'], $restaurant->name,
			'Name was not updated');
	}

	/**
	 *
	 * @test
	 */
	public function should_delete_a_restaurant_and_all_its_opening_times()
	{
		$this->repository->delete(1);
		$restaurant = $this->repository->findById(1);

		$openingTimesRepository = App::make('App\Repositories\OpeningTimeRepository');

		$openingTimes = $openingTimesRepository->findAllByRestaurantId(1);

		$this->assertEmpty($restaurant, '$restaurant is not empty.');
		$this->assertEmpty($openingTimes);
	}
}
