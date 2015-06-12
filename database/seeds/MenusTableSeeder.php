<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

/**
 * @author pschmidt
 */
class MenusTableSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'user_id' => 1,
				'name' => 'Menu #1',
			],
			[
				'user_id' => 1,
				'name' => 'Menu #2',
			]
		];

		foreach($data as $menu)
		{
			Menu::create($menu);
		}
	}

}