<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

/**
 * @pschmidt
 */
class UserTableSeeder extends Seeder {

	public function run()
	{
		$credentials = [
			'email' => 'testuser@test.de',
			'password' => 'test',
			'username' => 'testuser',
			'first_name' => 'Test',
			'last_name' => 'User',
		];

		Sentinel::registerAndActivate($credentials);
	}
}