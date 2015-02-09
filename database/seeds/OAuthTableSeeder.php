<?php
use Illuminate\Database\Seeder;

/**
 * @pschmidt
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

		$testToken = [
			'oj1zALA5emd42XmmzbJRMSmO8ClRBySPuzcHlvvA',
			1,
			time() + 60*60*24,
		];

		$testSession = [
			1,
			'testClient',
			'user',
			1
		];

		DB::insert(
			'insert into oauth_clients (id, secret, name, created_at, updated_at) values (?, ?, ?, ?, ?)',
			$testClient);

		DB::insert('insert into oauth_access_tokens (id, session_id, expire_time, created_at, updated_at) values (?, ?, ?, date("now"), DATE("now"))',
			$testToken);

		DB::insert('insert into oauth_sessions (id, client_id, owner_type, owner_id, created_at, updated_at) values(?, ?, ?, ?, DATE ("now"), DATE ("now"))',
			$testSession);
	}


}