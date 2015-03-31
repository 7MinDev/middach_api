<?php

use App\Models\OpeningTime;
use Illuminate\Database\Seeder;

/**
 * @author pschmidt
 */

class OpeningTimesTableSeeder extends Seeder
{
	/**
	 *
	 */
	public function run()
	{
		$data = [
			[
				'restaurant_id' => 1,
				'day_of_week' => 1,
				'opening_time' => '07:00:00',
				'closing_time' => '14:00:00'
			],
			[
				'restaurant_id' => 1,
				'day_of_week' => 2,
				'opening_time' => '07:00:00',
				'closing_time' => '14:00:00'
			],
			[
				'restaurant_id' => 1,
				'day_of_week' => 3,
				'opening_time' => '07:00:00',
				'closing_time' => '14:00:00'
			],
			[
				'restaurant_id' => 1,
				'day_of_week' => 4,
				'opening_time' => '07:00:00',
				'closing_time' => '14:00:00'
			],
			[
				'restaurant_id' => 1,
				'day_of_week' => 5,
				'opening_time' => '07:00:00',
				'closing_time' => '14:00:00'
			]
		];

		foreach($data as $openingTime)
		{
			OpeningTime::create($openingTime);
		}
	}
}