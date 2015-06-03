<?php
use App\Models\User;

/**
 * Base Testcase for all tests that need the authorization header (controllers)
 * because i dont have a clue how to disable middleware
 *
 * @author pschmidt
 */
class ControllerTestCase extends TestCase {

	private $access_token = 'oj1zALA5emd42XmmzbJRMSmO8ClRBySPuzcHlvvA';

	protected $ignore_authorization = false;

	public function setUp()
	{
		parent::setUp();

		if ($this->ignore_authorization)
		{
			/**
			 * @var $user User
			 */
			$user = User::find(1);
			Sentinel::setUser($user);
		}
	}

	public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
	{
		if (!$this->ignore_authorization)
		{
			$server['HTTP_Authorization'] = 'Bearer ' . $this->access_token;
		}

		return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
	}

	/**
	 * @param boolean $ignore_authorization
	 */
	protected function setIgnoreAuthorization($ignore_authorization)
	{
		$this->ignore_authorization = $ignore_authorization;
	}
}