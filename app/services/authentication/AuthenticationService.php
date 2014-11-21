<?php
use League\OAuth2\Server\Exception\AccessDeniedException;

/**
 * @author pschmidt
 */

class AuthenticationService {

	/**
	 * @param $username
	 * @param $password
	 * @return int|bool returns the user id of the logged in user or false if that user couldn't be logged in
	 */
	public static function login($username, $password)
	{
		// we pass the given login name as username and email
		// sentinel checks which column it will use
		$credentials = [
			[
				'username' => $username,
				'email' => $username,
			],
			'password' => $password,
		];

		$user = Sentinel::stateless($credentials);

		if ($user)
		{
			Sentinel::getUserRepository()
				->recordLogin($user);

			return $user->getUserId();
		}

		return false;
	}

	/**
	 * @param String $accessToken
	 * @return bool
	 */
	public static function logout($accessToken)
	{
		/*
		* raw query join and delete query which doesn't seem to work with laravels query builder,
		* so we have to do the raw query (sql injection) or with two queries. two queries is the way to go here
		*/
		//		DB::raw('DELETE oauth_sessions
		//         FROM oauth_sessions INNER JOIN oauth_access_tokens
		//         ON oauth_sessions.id = oauth_access_tokens.session_id
		//         WHERE oauth_access_tokens.id = "'. $accessToken . '"');

		$result = DB::table('oauth_sessions')
			->join('oauth_access_tokens', function($join) use ($accessToken)
			{
				$join->on('oauth_sessions.id', '=', 'oauth_access_tokens.session_id')
					->where('oauth_access_tokens.id', '=', $accessToken);
			})
			->first();

		DB::table('oauth_sessions')
			->delete($result->session_id);

		// todo maybe a check and returning false if something gone wrong?
		return true;
	}
}