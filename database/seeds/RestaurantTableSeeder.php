<?php
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

/**
 * @author pschmidt
 */
class RestaurantTableSeeder extends Seeder
{
	/**
	 *
	 */
	public function run()
	{
		$restaurant = [
			'user_id' => 1,
			'name' => 'Test Restaurant',
			'street' => 'Teststreet 123',
			'town' => 'Testtown',
			'postal_code' => 12345,
			'description' => 'Blablablablabla',
			'feedback_email' => 'restaurant@test.de',
			'website' => 'www.restaurant.de',
		];

		Restaurant::create($restaurant);
	}

}