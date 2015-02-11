<?php
use App\Models\Restaurant;
use App\Models\User;

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
	public function should_find_a_restaurant_and_its_owner()
	{
		$restaurant = $this->repository->findById(1);
		$this->assertTrue($restaurant instanceof Restaurant, 'return object was not an instance of Restaurant');

		$owner = $restaurant->owner;
		$this->assertTrue($owner instanceof User, 'owner was not an instance of User' . $owner);

		$this->assertEquals(1, $restaurant->id,
			'Expected $restaurant->id: 1 - actual: ' . $restaurant->id);
		$this->assertEquals('Test', $owner->first_name,
			'Expected $owner->first_name: Test - actual: ' . $owner->first_name);
	}
}