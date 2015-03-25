<?php

use Illuminate\Database\Seeder;

/**
 * @pschmidt
 */
class UserTableSeeder extends Seeder {

	public function run()
	{
		$credentials1 = [
			'email' => 'testuser@test.de',
			'password' => 'test',
			'username' => 'testuser',
			'first_name' => 'Test',
			'last_name' => 'User',
		];

		$credentials2 = [
			'email' => 'testuser2@test.de',
			'password' => 'test2',
			'username' => 'testuser2',
			'first_name' => 'Test',
			'last_name' => 'User 2'
		];

		Sentinel::registerAndActivate($credentials1);
		Sentinel::registerAndActivate($credentials2);
	}
}
