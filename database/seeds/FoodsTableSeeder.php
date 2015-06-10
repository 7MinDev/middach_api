<?php
use App\Models\Food;
use Illuminate\Database\Seeder;

/**
 * @author pschmidt
 */
class FoodsTableSeeder extends Seeder
{
	public function run()
	{
		$data = [
			'title' => 'Schnitzel vom Schwein',
			'sub_title' => 'Pfefferrahmsoße / Jägersoße',
			'price' => 5.20,
			'additional_info' => 'Inhaltsstoffe blabla',
		];

		Food::create($data);
	}
}
