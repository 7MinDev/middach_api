<?php
/**
 * @author pschmidt
 */

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->truncate();

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