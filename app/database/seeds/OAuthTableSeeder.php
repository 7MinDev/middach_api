<?php
/**
 * @author pschmidt
 */

class OAuthTableSeeder extends Seeder
{
	/**
	 *
	 */
	public function run()
	{
		$testClient = [
			'testClient',
			'testSecret',
			'Test Client',
			time(),
			time()
		];

		DB::insert(
			'insert into oauth_clients (id, secret, name, created_at, updated_at) values (?, ?, ?, ?, ?)',
			$testClient);
	}


}