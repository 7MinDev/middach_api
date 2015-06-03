<?php
use App\Models\Food;
use App\Repositories\Contracts\FoodRepositoryContract;

/**
 * @author pschmidt
 */
class FoodRepositoryTest extends TestCase
{
	/**
	 * @var FoodRepositoryContract
	 */
	private $repository;

	/**
	 *
	 */
	public function setUp()
	{
		parent::setUp();
		$this->repository = App::make('App\Repositories\FoodRepository');
	}


	/**
	 * @test
	 */
	public function should_create_a_food_and_return_it()
	{
		$data = [
			'user_id' => 1,
			'title' => 'Schnitzel vom Schwein',
			'sub_title' => 'Pfefferrahmsoße / Jägersoße',
			'price' => 5.20,
			'additional_info' => 'Inhaltsstoffe blabla',
		];

		$food = $this->repository->create($data);

		$this->assertTrue($food instanceof Food);
		$this->assertNotNull($food->id, '$food is null');
		$this->assertSame($data['title'], $food->title);
		$this->assertSame($data['sub_title'], $food->sub_title);
		$this->assertSame($data['price'], $food->price);
		$this->assertSame($data['additional_info'], $food->additional_info);

		$this->assertNotEmpty($food, '$food is empty.');
	}

	/**
	 * @test
	 */
	public function should_edit_a_dish_and_return_it()
	{
		$data = [
			'price' => 6.00,
			'sub_title' => 'Pfefferrahmsoße und Beilage Pommes',
		];

		$food = $this->repository->update(1, $data);

		$this->assertSame($data['price'], $food->price);
		$this->assertSame($data['sub_title'], $food->sub_title);

		$this->assertTrue($food instanceof Food);
	}
}
